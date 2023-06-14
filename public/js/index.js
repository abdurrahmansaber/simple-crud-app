document.getElementById("add-product-btn").onclick = function () {
    location.href = "add-product.php";
};

const container = document.getElementById('container');

container.addEventListener('click', function (event) {
    const clickedDiv = event.target.closest('.clickable-div');
    if (clickedDiv) {
        const divId = clickedDiv.getAttribute('data-id');
        const divProductType = clickedDiv.getAttribute('data-type');
        window.location.href = `edit.php?id=${divId}&type=${divProductType}`;
    }
});