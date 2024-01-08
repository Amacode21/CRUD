const input_brand = document.querySelector("#car_brand");
const input_price = document.querySelector("#car_price");
const rem = document.querySelector("#reminder_edit");
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
