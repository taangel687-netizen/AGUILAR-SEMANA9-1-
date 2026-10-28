<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%!
  private static String esc(String s) {
    if (s == null) return "";
    return s.replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;")
            .replace("\"", "&quot;").replace("'", "&#x27;");
  }
%>
<%
  // Si no hay datos en sesión, se vuelve al formulario
  if (session.getAttribute("nombre") == null) {
    response.sendRedirect("index.jsp");
    return;
  }
%>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Resultado</title>
<style>
  body{font-family:Arial,sans-serif;max-width:560px;margin:2rem auto;padding:0 1rem}
  table{border-collapse:collapse} td,th{border:1px solid #999;padding:.4rem .8rem;text-align:left}
</style></head>
<body>
  <h1>Lab 09 - JSP</h1>
  <h2 style="color:#1b5e20">Formulario recibido correctamente</h2>
  <table>
    <tr><th>Nombre</th><td><%= esc((String) session.getAttribute("nombre")) %></td></tr>
    <tr><th>Correo</th><td><%= esc((String) session.getAttribute("email")) %></td></tr>
    <tr><th>Edad</th><td>${sessionScope.edad}</td></tr>
    <tr><th>Mensaje</th><td><%= esc((String) session.getAttribute("mensaje")) %></td></tr>
    <tr><th>Fecha</th><td><%= esc((String) session.getAttribute("fecha")) %></td></tr>
  </table>
  <p>Envíos en esta sesión: <strong>${sessionScope.envios}</strong></p>
  <p>Método: ${pageContext.request.method} |
     ID de sesión: <%= esc(session.getId().substring(0, 8)) %>…</p>
  <p><a href="index.jsp">Enviar otro formulario</a></p>
</body>
</html>
