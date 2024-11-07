document.addEventListener("DOMContentLoaded", function () {
  var textarea = document.getElementById("frog_description");
  var indicator = document.getElementById("frog_description_indicator");

  if (textarea) {
    var editor = CodeMirror.fromTextArea(textarea, {
      lineNumbers: true,
      mode: "yaml", // Choose a mode
      theme: "default", // Choose a theme
      // height
    });

    editor.on("change", function (cm) {
      textarea.value = cm.getValue();
      var yamlContent = textarea.value;
      console.log(yamlContent);
      jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        data: {
          action: "validate_frog_yaml",
          yaml_content: yamlContent,
        },
        success: function (response) {
          indicator.innerHTML = response.data;
        },
      });
    });
  }
});

// document.addEventListener("DOMContentLoaded", function () {
//   const frogDescription = document.getElementById("frog_description");

//   frogDescription.addEventListener("change", function () {
//     const yamlContent = frogDescription.value;

//     jQuery.ajax({
//       url: ajaxurl,
//       type: "POST",
//       data: {
//         action: "validate_frog_yaml",
//         yaml_content: yamlContent,
//       },
//       success: function (response) {
//         if (response.success) {
//           console.log("YAML is valid");
//           // Optionally, update the UI to show valid YAML
//         } else {
//           console.log("YAML is invalid:", response.data);
//           // Optionally, show validation error to the user
//         }
//       },
//     });
//   });
// });
