const form = document.getElementById("etiquetaForm");
const fields = [
    "material",
    "lote",
    "data_esterilizacao",
    "validade",
    "temperatura",
    "responsavel",
];

fields.forEach((field) => {
    document
        .querySelector(`[name=${field}]`)
        .addEventListener("input", updatePreview);
});

function updatePreview() {
    fields.forEach((field) => {
        const value = document.querySelector(`[name=${field}]`).value;
        document.getElementById(
            `preview-${field.replace("_", "-")}`
        ).textContent = value;
    });
}

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    const response = await axios.post("gerar_pdf.php", formData, {
        responseType: "blob",
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });

    const blob = new Blob([response.data], {
        type: "application/pdf",
    });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "etiqueta.pdf";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
});
