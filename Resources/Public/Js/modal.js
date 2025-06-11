document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll("[data-confirm]").forEach(button => {
    button.addEventListener("click", function (event) {
      const message = button.getAttribute("data-confirm");
      const form = button.closest("form");

      if (!message || !confirm(message)) {
        event.preventDefault();
        return;
      }

      if (form) {
        form.submit();
      } else {
        console.warn("No parent form found for confirmation button.");
      }
    });
  });
});
