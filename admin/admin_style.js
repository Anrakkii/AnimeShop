//Confirm button before running deleting

$(document).ready(function(){
    $("a.delete").click(function(e){
        if(!confirm('Bạn có chắc muốn xòa mục này?')){
            e.preventDefault();
            return false;
        }
        return true;
    });
});

//Arlet after click add button successfully
var formA = document.getElementById('formAdd');

function myAFunction() {
  if (formA.checkValidity()) {
    alert("Xác nhận thêm sản phẩm này?");
  }
}

//Arlet after click update button successfully
var formU = document.getElementById('formUpdate');

function myUFunction() {
  if (formU.checkValidity()) {
    alert("Xác nhận cập nhật sản phẩm này?");
  }
}