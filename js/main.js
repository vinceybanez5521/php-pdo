// console.log("Hello World!");

const deletePositionBtns = document.querySelectorAll(".delete-position");
// console.log(deletePositionBtns);

deletePositionBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    if (confirm("Are you sure you want to delete this position?")) {
      let positionId = e.target.value;

      $.post("delete.php", { id: positionId }).done(function (data) {
        window.location = "./";
      });
    }
  });
});

const deleteEmployeeBtns = document.querySelectorAll(".delete-employee");
// console.log(deleteEmployeeBtns);

deleteEmployeeBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    if (confirm("Are you sure you want to delete this employee?")) {
      let employeeId = e.target.value;

      $.post("delete.php", { id: employeeId }).done(function (data) {
        window.location = "./";
      });
    }
  });
});
