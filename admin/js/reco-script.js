const API_URL = ajax_var.resturl;
const API_URL_LICENSE = ajax_var.restlicenseurl;
const NONCE = ajax_var.nonce;

// Helper function to hide all tab content
function hideAllTabContent() {
  const tabContentElements = document.getElementsByClassName("tabcontent");
  for (let element of tabContentElements) {
    element.style.display = "none";
  }
}

// Helper function to deactivate all tab links
function deactivateAllTabLinks() {
  const tabLinkElements = document.getElementsByClassName("tablinks");
  for (let element of tabLinkElements) {
    element.className = element.className.replace(" active", "");
    const imgElement = element.querySelector("img");
    if (imgElement) {
      const imgSrc = imgElement.getAttribute("src");
      imgElement.setAttribute("src", imgSrc.replace("active", ""));
    }
  }
}

function openTab(evt, tabName, activePage = null) {
  hideAllTabContent();
  deactivateAllTabLinks();

  document.getElementById(tabName).style.display = "block";

  const targetElement = activePage
    ? document.getElementById(activePage)
    : evt.currentTarget;
  targetElement.className += " active";

  const imgSrc = targetElement.querySelector("img").getAttribute("src");
  if (imgSrc) {
    const newImgSrc = imgSrc.replace(".svg", "active.svg");
    targetElement.querySelector("img").setAttribute("src", newImgSrc);
  }
}

const RecoApi = {
  get(endpoint) {
    return fetch(endpoint, {
      method: "GET",
      headers: {
        Accept: "application/json",
        "X-WP-Nonce": NONCE,
      },
    })
      .then(this._handleError)
      .then(this._handleContentType)
      .catch(this._throwError);
  },

  post(endpoint, body) {
    return fetch(endpoint, {
      method: "POST",
      headers: {
        "content-type": "application/json",
        "X-WP-Nonce": NONCE,
      },
      body: body,
    })
      .then(this._handleError)
      .then(this._handleContentType)
      .catch(this._throwError);
  },

  _handleError(err) {
    if (!err.ok) throw new Error(err.statusText);
    return err;
  },

  _handleContentType(res) {
    const contentType = res.headers.get("content-type");
    if (contentType && contentType.includes("application/json")) {
      return res.json();
    }
    throw new Error("Expected JSON response.");
  },

  _throwError(err) {
    throw new Error(err);
  },
};

// Function to initialize range slider
function initializeRangeSlider() {
  const sliderEl = document.querySelector("#range2");
  const sliderValue = document.querySelector(".value2");

  sliderEl.addEventListener("input", (event) => {
    const tempSliderValue = event.target.value;
    sliderValue.textContent = tempSliderValue;
    const progress = (tempSliderValue / sliderEl.max) * 100;
    sliderEl.style.background = `linear-gradient(to right, #4272F9 ${progress}%, #ccc ${progress}%)`;
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const resizeDimensions = document.querySelector(
    "#imageSettingsGeneral .resizeDimensions"
  );

  const width = document.querySelector("#widthGeneral");
  const height = document.querySelector("#heightGeneral");

  //Extra enableReziseDimensions side effects
  resizeDimensions.addEventListener("click", (e) => {
    toggleResizeDimensionsField(width, resizeDimensions);
    toggleResizeDimensionsField(height, resizeDimensions);
  });
  
  const toggleResizeDimensionsField = (el, e) => {
    if (e.checked) {
      el.classList.remove("cursor-not-allowed");
      el.classList.remove("pointer-events-none");
      el.classList.remove("opacity-40");
    } else {
      el.classList.add("cursor-not-allowed");
      el.classList.add("pointer-events-none");
      el.classList.add("opacity-40");
    }
  }
  toggleResizeDimensionsField(width, resizeDimensions);
  toggleResizeDimensionsField(height, resizeDimensions);
});
// Function to handle saving the settings form
function saveSettings() {
  const roleInputs = document.querySelectorAll(".role-to-ignore input");
  let roleCollection = Array.from(roleInputs)
    .filter((input) => input.checked)
    .map((input) => input.getAttribute("data-name"))
    .join(",");

  const enableResizeValue = document.querySelector(".enableresize input")
    .checked
    ? 1
    : 0;

  const convertPngToJpgValue = document.querySelector(
    "#imageSettingsGeneral input[name='convertPngToJpg']"
  ).checked
    ? true
    : false;

  const resizeDimensions = document.querySelector(
    "#imageSettingsGeneral input[name='resizeDimensions']"
  );
  const enableResizeDimensions = resizeDimensions.checked ? true : false;

  const imageOptions = {
    general: {
      width: document.querySelector("#imageSettingsGeneral input[name='width']")
        .value,
      height: document.querySelector(
        "#imageSettingsGeneral input[name='height']"
      ).value,
      convert: convertPngToJpgValue,
      enableResizeDimensions: enableResizeDimensions,
      compression: document.querySelector(
        "#imageSettingsGeneral input[type='range'] + div"
      ).innerText,
    },
  };

  const data = JSON.stringify({
    ignoredroles: roleCollection,
    enableresize: enableResizeValue,
    imageoptions: [imageOptions],
  });

  RecoApi.post(API_URL, data)
    .then(() => location.reload())
    .catch((error) => console.error(error));
}

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("openDefault").click();
  initializeRangeSlider();

  RecoApi.get(API_URL)
    .catch((error) => console.error(error));

  document.querySelectorAll("#saveSettings").forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      saveSettings();
    });
  });
});