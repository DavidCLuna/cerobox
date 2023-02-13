# Proyecto Cerobox Entrevista
[Link del Proyecto](https://choosealicense.com/licenses/mit/)

**Usuario y contraseña para ingresar al sistema:**  
**User:** email@example.org  
**password:** password  


### La arquitectura del proyecto está compuesta por:
- Backend: Está desarrollado en PHP con Laravel. Lo creé modo API, independiente del front, con autenticación por token JWT con la librería Sanctum, las únicas rutas no protegias, son las de leer los servicios de clientes, ya que pueden acceder los usuarios sin estar logueados. Desarrollé también unas pruebas unitarias de algunos endpoints. 
- Frontend: Está desarrollado en Vue.JS con la librería de diseño Vuetify, para las alertas usé Sweet Alert, para las peticiones Axios, para los datatables Prime Vue.