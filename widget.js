$(document).ready(function () {
  // Append the translator widget
  $('body').append(`
    <div id="langWidget">
      <select id="langSelector">
        <option value="">🌐 Translate Page</option>
        <option value="hi">Hindi</option>
        <option value="fr">French</option>
        <option value="es">Spanish</option>
      </select>
    </div>
  `);

  // Widget style
  $('#langWidget').css({
    position: 'fixed',
    bottom: '20px',
    right: '20px',
    background: '#007BFF',
    padding: '10px',
    borderRadius: '10px',
    zIndex: 9999
  });

  $('#langSelector').css({
    padding: '6px',
    borderRadius: '5px',
    border: 'none',
    color: '#007BFF',
    fontWeight: 'bold'
  });

	//fetching all elements from the target page
  $('#langSelector').change(function () {
    let lang = $(this).val();
    if (!lang) return;

    let textNodes = [];
    let elements = [];

    $("*:not(script):not(style):not(noscript)").each(function () {
      let el = $(this);
      if (el.children().length === 0 && el.text().trim()) {
        textNodes.push(el.text().trim());
        elements.push(el);
      }
    });

    // Call to PHP backend to use Gemini
    $.ajax({
      url: 'translate.php',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({
        lang: lang,
        texts: textNodes
      }),
      success: function (data) { 
		if (data && Array.isArray(data)) {
			for (let i = 0; i < elements.length; i++) {
			elements[i].text(data[i] || textNodes[i]);
			}
		} else {
			alert("Invalid translation response.");
		}
		},
      error: function (err) {
        console.error("Translation failed:", err.responseText);
        alert("Translation failed.");
      }
    });
  });
});
