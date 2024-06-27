function replaceTextInTextarea(element, searchValue, replaceValue) {
  var escapedSearchValue = searchValue.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
  var regex = new RegExp(escapedSearchValue, "g");
  element.value = element.value.replace(regex, replaceValue);
}

document.addEventListener("DOMContentLoaded", function () {
  var adminContent = document.getElementById("wp-content-wrap"),
    textarea = adminContent.querySelector(".wp-editor-area");

  if (textarea) {
    textarea.addEventListener("blur", function (event) {
      var target = event.target;
      var searchText = "https://x.com";
      var replaceText = "https://twitter.com";

      if (target.value.includes(searchText)) {
        replaceTextInTextarea(textarea, searchText, replaceText);
      }
    });
  }
});
