//#region Modales For Vuelos
//Delete Modal for Vuelos
function openDeleteModal(id) {
    const modal = document.getElementById("deleteModal");
    modal.style.display = "block";

    const confirmButton = document.getElementById("confirmDelete");
    const cancelButton = document.getElementById("cancelDelete");
    const closeButton = document.getElementById("modalClose");

    // When the user clicks the 'Delete' button in the modal
    confirmButton.onclick = function () {
        window.location.href = "modify_vuelo.php?id=" + id;
    };

        cancelButton.onclick = function () {
            modal.style.display = "none";
        };

    // When the user clicks the 'X' button or outside the modal, close the modal
    closeButton.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}


//Modal to modify records in database Table Vuelos
function openModifyModal(id, origen, destino, aeronave, fecha, arribado, estado) {
    document.getElementById("flightId").value = id;
    const modal = document.getElementById("modifyModal");
    modal.style.display = "block";
    const confirmButton = document.getElementById("confirm");
    const cancelButton = document.getElementById("cancel");
    const closeButton = document.getElementById("modalClose");

    document.getElementById("vueloOrigen").value = origen;
    document.getElementById("vueloDestino").value = destino;
    document.getElementById("idAeronave").value = aeronave;
    document.getElementById("fechaVuelo").value = fecha;
    document.getElementById("vueloArribado").value = arribado;
    document.getElementById("estado").value = estado;

    selectedFlightId = id; // Store the selected flight ID


    // When the user clicks the 'Delete' button in the modal
    confirmButton.onclick = function () {
        window.location.href = "modify_vuelo.php?id=" + id;
    };

    cancelButton.onclick = function () {
        modal.style.display = "none";
    };

    // When the user clicks the 'X' button or outside the modal, close the modal
    closeButton.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}
//#endregion


//#region Modales For Aeronaves
//Insert Modal for Aeronaves
function openInsertModalAeronave() {

    const modal = document.getElementById("insertAeronaveModal");
    modal.style.display = "block";

    const confirmButton = document.getElementById("confirm");
    const cancelButton = document.getElementById("cancel");
    const closeButton = document.getElementById("modalClose");

  

    cancelButton.onclick = function () {
        modal.style.display = "none";
    };

    // When the user clicks the 'X' button or outside the modal, close the modal
    closeButton.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}






//#endregion


//#region Modales For Aeropuertos
//Insert Modal for Aeropuertos
function openInsertModalAeropuerto() {

    const modal = document.getElementById("insertAeropuertoModal");
    modal.style.display = "block";

    const confirmButton = document.getElementById("confirm");
    const cancelButton = document.getElementById("cancel");
    const closeButton = document.getElementById("modalClose");

  

    cancelButton.onclick = function () {
        modal.style.display = "none";
    };

    // When the user clicks the 'X' button or outside the modal, close the modal
    closeButton.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}







//#endregion

