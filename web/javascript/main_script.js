const button_show = document.querySelectorAll(".button");

button_show.forEach((btn) => {
  btn.addEventListener("click", function () {
    const id = this.getAttribute("id");
    const get_card = document.querySelector(`#hero-${id}`);
    get_card.querySelector(`#btn-${id}`).addEventListener("click", () => {
      get_card.style.visibility = "hidden";
    });

    get_card.style.visibility = "visible";
  });
});
