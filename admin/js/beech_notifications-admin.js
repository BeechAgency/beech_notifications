console.log("Beech Admin JS");
jQuery(document).ready(function ($) {
  var params = new URLSearchParams(window.location.search);
  var extras = params.get("displayextraoptions");

  if (extras) {
    jQuery("#extrasTab").fadeIn();
  }
  $("#upload-btn").click(function (e) {
    e.preventDefault();
    var image = wp
      .media({
        title: "Upload Image",
        // mutiple: true if you want to upload multiple files at once
        multiple: false,
      })
      .open()
      .on("select", function (e) {
        // This will return the selected image from the Media Uploader, the result is an object
        var uploaded_image = image.state().get("selection").first();
        // We convert uploaded_image to a JSON object to make accessing it easier
        // Output to the console uploaded_image
        console.log(uploaded_image);
        var image_url = uploaded_image.toJSON().url;
        // Let's assign the url value to the input field
        $("#BEECH_notifications_screen_background_image").val(image_url);
      });
  });
});
jQuery(document).ready(function ($) {
  $("#upload-btn2").click(function (e) {
    e.preventDefault();
    var image = wp
      .media({
        title: "Upload Image",
        // mutiple: true if you want to upload multiple files at once
        multiple: false,
      })
      .open()
      .on("select", function (e) {
        // This will return the selected image from the Media Uploader, the result is an object
        var uploaded_image = image.state().get("selection").first();
        // We convert uploaded_image to a JSON object to make accessing it easier
        // Output to the console uploaded_image
        console.log(uploaded_image);
        var image_url = uploaded_image.toJSON().url;
        // Let's assign the url value to the input field
        $("#BEECH_notifications_screen_brand_image").val(image_url);
      });
  });
});
jQuery(document).ready(function ($) {
  $("#upload-btn3").click(function (e) {
    e.preventDefault();
    var image = wp
      .media({
        title: "Upload Image",
        // mutiple: true if you want to upload multiple files at once
        multiple: false,
      })
      .open()
      .on("select", function (e) {
        // This will return the selected image from the Media Uploader, the result is an object
        var uploaded_image = image.state().get("selection").first();
        // We convert uploaded_image to a JSON object to make accessing it easier
        // Output to the console uploaded_image
        console.log(uploaded_image);
        var image_url = uploaded_image.toJSON().url;
        // Let's assign the url value to the input field
        $("#BEECH_notifications_screen_background_texture").val(image_url);
      });
  });
});
jQuery(document).ready(function ($) {
  $("#upload-btn4").click(function (e) {
    e.preventDefault();
    var image = wp
      .media({
        title: "Upload Image",
        // mutiple: true if you want to upload multiple files at once
        multiple: false,
      })
      .open()
      .on("select", function (e) {
        // This will return the selected image from the Media Uploader, the result is an object
        var uploaded_image = image.state().get("selection").first();
        // We convert uploaded_image to a JSON object to make accessing it easier
        // Output to the console uploaded_image
        console.log(uploaded_image);
        var image_url = uploaded_image.toJSON().url;
        // Let's assign the url value to the input field
        $("#BEECH_notifications_screen_partnership_logo").val(image_url);
      });
  });
});

function openTab(evt, tabName) {
  evt.preventDefault();
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tab-content");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tab-link");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}


/**
 * Handle tag inputs
 */
jQuery(document).ready(function ($) { 

  const tagInputs = document.querySelectorAll(".BN__tags-input-container");

  if(!tagInputs) return false;

  function handleTag( template, text, output ) {
    const clone = template.content.cloneNode(true);

    //clone.textContent = text;
    clone.querySelector("span").textContent = text;

    clone.querySelector("button").addEventListener("click", removeTag);

    output.appendChild(clone);
  }


  function updateHiddenInput( group ) {
    const realInput = group.querySelector("textarea");
    const outputArea = group.querySelector(".BN__tags-display");

    const tagsText = outputArea.querySelectorAll('.BN__tag span');

    const tags = [];

    tagsText.forEach( tag => {
      tags.push(tag.textContent.trim());
    })

    const tagsString = tags.join(',')

    realInput.innerHTML = tagsString;
  }

  function createInitialTags( hiddenInput, template, output) {
    const tagString = hiddenInput.value;

    const tagArray = tagString.split(',');

    tagArray.forEach( tagText => {
      handleTag(template, tagText, output);
    })
  }

  function removeTag(e) {
    e.preventDefault();

    const el = e.currentTarget;
    const group = el.parentElement.parentElement.parentElement.parentElement;

    el.parentElement.remove();
    updateHiddenInput(group);

  }

  tagInputs.forEach( group => {

    const input = group.querySelector('input');
    const addButton = group.querySelector("input + button");
    const tagTemplate = group.querySelector("template");
    const realInput = group.querySelector('textarea');

    const outputArea = group.querySelector('.BN__tags-display');

    createInitialTags(realInput, tagTemplate, outputArea);


    addButton.addEventListener("click", (e) => {
        e.preventDefault();
        // Get the text entered by the user
        const text = input.value.trim();

        // Clear the input field
        input.value = "";
        handleTag(tagTemplate, text, outputArea);

        updateHiddenInput(group);
        // Move the entered text to the output element
        //outputArea.textContent = outputArea.textContent + text;
    });

  })

});

jQuery(document).ready(function ($) {
  // Trigger the Add Form button for Gravity Forms if TinyMCE is active
  if (typeof gform_add_form_button !== "undefined") {
    gform_add_form_button();
  }
});