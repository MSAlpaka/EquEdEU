(function () {
  document.addEventListener("DOMContentLoaded", function () {
    console.log("EquEd LMS Dashboard loaded");

    // Beispiel: Hervorheben aktiver Kachel
    const tiles = document.querySelectorAll(".dashboard-tile");
    tiles.forEach(tile => {
      tile.addEventListener("click", () => {
        tiles.forEach(t => t.classList.remove("active"));
        tile.classList.add("active");
      });
    });
  });
})();
