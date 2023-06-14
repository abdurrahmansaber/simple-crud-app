const productType = document.getElementById('productType');
const bookDiv = document.getElementById('book-attrs');
const dvdDiv = document.getElementById('dvd-attrs');
const furnitureDiv = document.getElementById('furniture-attrs');
const cancelAddBtn = document.getElementById('cancel-add-btn');

cancelAddBtn.addEventListener('click', function () {
    location.href = 'index.php';
});

function displayBookDiv() {
    bookDiv.style.display = 'block';
    dvdDiv.style.display = 'none';
    furnitureDiv.style.display = 'none';

    setRequiredInputs(bookDiv, true);
    setRequiredInputs(dvdDiv, false);
    setRequiredInputs(furnitureDiv, false);
}

function displayFurnitureDiv() {
    bookDiv.style.display = 'none';
    dvdDiv.style.display = 'none';
    furnitureDiv.style.display = 'block';

    setRequiredInputs(furnitureDiv, true);
    setRequiredInputs(bookDiv, false);
    setRequiredInputs(dvdDiv, false);
}

function displayDvdDiv() {
    bookDiv.style.display = 'none';
    dvdDiv.style.display = 'block';
    furnitureDiv.style.display = 'none';

    setRequiredInputs(dvdDiv, true);
    setRequiredInputs(bookDiv, false);
    setRequiredInputs(furnitureDiv, false);
}

function setRequiredInputs(container, required) {
    const inputElements = container.querySelectorAll('input');
    inputElements.forEach((input) => {
        input.required = required;
    });
}

function showCorrectDiv() {
    const selectedValue = productType.value;
    if (selectedValue === 'book') {
        displayBookDiv();
    } else if (selectedValue === 'dvd') {
        displayDvdDiv();
    } else {
        displayFurnitureDiv();
    }
}

productType.addEventListener('change', function () {
    showCorrectDiv();
});

function getParameterByName(name) {
    const urlParams = new URLSearchParams(window.location.search);
    console.log(urlParams.get(name))
    return urlParams.get(name);
}

function setInitialDisplayFromURLParam() {
    const parameterValue = getParameterByName('type');
    if (parameterValue) {
        const option = productType.querySelector(`option[value="${parameterValue}"]`);
        if (option) {
            productType.value = parameterValue;
            showCorrectDiv();
        }
    }
}

setInitialDisplayFromURLParam();
