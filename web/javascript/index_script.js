const input_brand = document.querySelector("#car_brand");
const input_price = document.querySelector("#car_price");
const input_img = document.querySelector("#file_path");
const clr_img = document.querySelector(".clr_img");
const clr_form = document.querySelector(".clr_form");
const rem = document.querySelector("#reminder_edit");
const preview = document.querySelector("#preview");

let disabledInput = false;
input_brand.addEventListener("input", () => {
  const brand_value = input_brand.options[input_brand.selectedIndex].value;
  if (brand_value === "Toyota") {
    input_price.value = "90000";
  } else if (brand_value === "Hyundai") {
    input_price.value = "90500";
  } else if (brand_value === "BMW") {
    input_price.value = "100000";
  } else if (brand_value === "Mercedes-Benz") {
    input_price.value = "100500";
  } else if (brand_value === "Lamborghini") {
    input_price.value = "200000";
  } else {
    input_price.value = "200500";
  }
  rem.style.visibility = "hidden";
});

input_price.addEventListener("focus", () => {
  rem.style.visibility = "visible";
  input_price.disabled = true;
  // input_price.value = input_price.value.slice(0, -1);
});

input_price.addEventListener("blur", () => {
  input_price.disabled = false;
});

window.addEventListener("click", () => {
  rem.style.visibility = "hidden";
});

input_img.addEventListener("input", function (e) {
  const file = this.files[0];

  const pre = document.querySelector(".pre");
  pre.style.display = "none";
  preview.src = URL.createObjectURL(file);
});

clr_img.addEventListener("click", () => {
  input_img.value = "";
  preview.src = "";
});

clr_form.addEventListener("click", () => {
  input_price.value = "90000"; // Back to default
  input_img.value = ""; // Back to default
  preview.src = ""; // Back to default
  document.querySelectorAll(`select`).forEach((selected) => {
    selected.selectedIndex = 0;
  });

  document.querySelectorAll(`input[type="text"]`).forEach((item) => {
    item.value = "";
  });
});
