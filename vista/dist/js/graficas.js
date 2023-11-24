// Función para guardar el contenido como PDF
function guardarComoPDF() {
    // Verificar si el elemento existe
    var divContent = document.getElementById('contenido');
    if (divContent) {
      // Capturar los datos del div
      var content = divContent.innerHTML;
  
      // Crear un nuevo documento PDF
      var doc = new jsPDF();
  
      // Agregar los datos capturados al PDF
      doc.fromHTML(content, 15, 15);
  
      // Guardar el PDF
      doc.save('graficas.pdf');
    } else {
      console.error('El elemento con el id "contenido" no fue encontrado.');
    }
  }
  
  // Asignar la función al botón
  document.getElementById('descargar_pdf').addEventListener('click', guardarComoPDF);
  