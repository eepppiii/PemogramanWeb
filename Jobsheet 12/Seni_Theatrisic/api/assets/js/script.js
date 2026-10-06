// ============ POPUP NOTIFIKASI (Login & Umum) ============
function showPopup(title, message, type) {
  var iconMap = { success: "✅", error: "❌", warning: "⚠️" };
  var colorMap = { success: "#10b981", error: "#ef4444", warning: "#f59e0b" };
  var bgMap = { success: "#d1fae5", error: "#fee2e2", warning: "#fef3c7" };

  var existing = document.getElementById("custom-popup-overlay");
  if (existing) existing.remove();

  var overlay = document.createElement("div");
  overlay.id = "custom-popup-overlay";
  overlay.style.cssText =
    "position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(6px); display: flex; align-items: center; justify-content: center; z-index: 99999; animation: popupFadeIn 0.25s ease-out;";

  var box = document.createElement("div");
  box.style.cssText =
    "background: #fff; padding: 2rem; border-radius: 20px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3); animation: popupScaleUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); border-top: 6px solid " +
    (colorMap[type] || colorMap.error) + ";";

  box.innerHTML =
    '<div style="width: 70px; height: 70px; margin: 0 auto 1rem; background: ' +
    (bgMap[type] || bgMap.error) +
    '; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">' +
    (iconMap[type] || iconMap.error) +
    "</div>" +
    "<h3 style=\"font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; font-family: 'Inter', sans-serif;\">" +
    escapeHtml(title) +
    "</h3>" +
    "<p style=\"font-size: 0.9rem; color: #64748b; margin-bottom: 1.5rem; font-family: 'Inter', sans-serif;\">" +
    escapeHtml(message) +
    "</p>" +
    '<button type="button" onclick="closePopup()" style="width: 100%; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, ' +
    (colorMap[type] || colorMap.error) + ", " + (colorMap[type] || colorMap.error) +
    "cc); color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: all 0.2s ease; font-family: 'Inter', sans-serif;\" onmouseover=\"this.style.transform='translateY(-2px)'\" onmouseout=\"this.style.transform='translateY(0)'\">Mengerti</button>";

  overlay.appendChild(box);
  document.body.appendChild(overlay);

  overlay.addEventListener("click", function (e) {
    if (e.target === overlay) closePopup();
  });
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closePopup();
  });
}

function closePopup() {
  var overlay = document.getElementById("custom-popup-overlay");
  if (overlay) {
    overlay.style.animation = "popupFadeOut 0.2s ease-in";
    setTimeout(function () { overlay.remove(); }, 200);
  }
}

function escapeHtml(text) {
    var map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

if (!document.getElementById("popup-animations")) {
  var style = document.createElement("style");
  style.id = "popup-animations";
  style.textContent = "@keyframes popupFadeIn { from { opacity: 0; } to { opacity: 1; } } @keyframes popupFadeOut { from { opacity: 1; } to { opacity: 0; } } @keyframes popupScaleUp { from { opacity: 0; transform: scale(0.85); } to { opacity: 1; transform: scale(1); } }";
  document.head.appendChild(style);
}

window.showPopup = showPopup;
window.closePopup = closePopup;