function initConditionalVisibility(
  selectRef,
  targetRef,
  triggerValue,
  displayMode = "block",
) {
  const select =
    typeof selectRef === "string"
      ? document.querySelector(selectRef)
      : selectRef;
  const target =
    typeof targetRef === "string"
      ? document.querySelector(targetRef)
      : targetRef;

  if (!select || !target) {
    console.warn("Элементы для настройки видимости не найдены в DOM.");
    return;
  }

  const toggle = () => {
    const isMatch = select.value.trim() === triggerValue;
    target.style.display = isMatch ? displayMode : "none";
  };

  select.addEventListener("change", toggle);
  toggle();
}

document.addEventListener("DOMContentLoaded", () => {
  initConditionalVisibility(
    "#select-tariff",
    ".input-tariff",
    "create-tariff",
    "block",
  );

  initConditionalVisibility("#spots", ".input-spot", "create-spot", "block");
});
