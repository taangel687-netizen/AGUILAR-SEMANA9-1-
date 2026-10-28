<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%!
  // Escapa texto antes de imprimirlo en HTML (previene XSS)
  private static String esc(String s) {
    if (s == null) return "";
    return s.replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;")
            .replace("\"", "&quot;").replace("'", "&#x27;");
  }

  public void jspInit() {
    System.out.println("[lab09] procesar.jsp -> jspInit()");
  }
  public void jspDestroy() {
    System.out.println("[lab09] procesar.jsp -> jspDestroy()");
  }
%>
<%
  // 1) Codificación de los parámetros (antes de leer cualquier parámetro)
  request.setCharacterEncoding("UTF-8");

  // 2) Solo POST; otro método -> 405 Method Not Allowed
  if (!"POST".equals(request.getMethod())) {
    response.setHeader("Allow", "POST");
    response.sendError(HttpServletResponse.SC_METHOD_NOT_ALLOWED);
    return;
  }

  // 3) Lectura de parámetros
  String nombre  = request.getParameter("nombre");
  String email   = request.getParameter("email");
  String edadStr = request.getParameter("edad");
  String mensaje = request.getParameter("mensaje");

  nombre  = (nombre  == null) ? "" : nombre.trim();
  email   = (email   == null) ? "" : email.trim();
  mensaje = (mensaje == null) ? "" : mensaje.trim();

  // 4) Validación
  java.util.List<String> errores = new java.util.ArrayList<>();
  if (nombre.isEmpty() || nombre.length() > 60) {
    errores.add("El nombre es obligatorio (máximo 60 caracteres).");
  }
  if (!email.matches("^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$")) {
    errores.add("El correo electrónico no es válido.");
  }
  int edad = 0;
  try {
    edad = Integer.parseInt(edadStr == null ? "" : edadStr.trim());
    if (edad < 16 || edad > 100) {
      errores.add("La edad debe estar entre 16 y 100.");
    }
  } catch (NumberFormatException ex) {
    errores.add("La edad debe ser un número entero.");
  }
  if (mensaje.length() > 300) {
    errores.add("El mensaje no puede superar los 300 caracteres.");
  }

  // 5) Con errores: 400 Bad Request y se muestran los mensajes
  if (!errores.isEmpty()) {
    response.setStatus(HttpServletResponse.SC_BAD_REQUEST);
%>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Error de validación</title></head>
<body style="font-family:Arial,sans-serif;max-width:560px;margin:2rem auto">
  <h1>Lab 09 - JSP</h1>
  <h2 style="color:#b00020">Datos no válidos (400 Bad Request)</h2>
  <ul>
    <% for (String err : errores) { %>
      <li style="color:#b00020"><%= esc(err) %></li>
    <% } %>
  </ul>
  <p><a href="index.jsp">Volver al formulario</a></p>
</body>
</html>
<%
    return;
  }

  // 6) Todo correcto: se guarda en la sesión y se redirige (302)
  session.setAttribute("nombre", nombre);
  session.setAttribute("email", email);
  session.setAttribute("edad", edad);
  session.setAttribute("mensaje", mensaje);
  session.setAttribute("fecha", new java.util.Date().toString());
  Integer envios = (Integer) session.getAttribute("envios");
  session.setAttribute("envios", (envios == null) ? 1 : envios + 1);

  response.sendRedirect("resultado.jsp");
%>
