// on attend le chargement du DOM avec d'exécuter le code js
window.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll("#delete");
  forms.forEach(function (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      Swal.fire({
        title: "Suppression d'un livre",
        text: "Voulez vous supprimer définitivement le livre ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
      }).then(function (result) {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
});