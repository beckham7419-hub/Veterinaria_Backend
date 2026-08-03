package com.example.veterinaria_respaldo_app

data class Dueno(
    val id: Int,
    val nombre_completo: String,
    val telefono: String,
    val correo: String,
    val direccion: String?,
    val activo: Boolean
)

data class Mascota(
    val id: Int,
    val dueno_id: Int,
    val nombre: String,
    val especie: String,
    val raza: String?,
    val sexo: String,
    val fecha_nacimiento: String?,
    val color: String?,
    val foto_url: String?,
    val activo: Boolean
)

// --- Lo que se ENVÍA al backend ---

data class LoginRequest(
    val correo: String,
    val contrasena: String
)

data class RegistroDuenoRequest(
    val nombre_completo: String,
    val telefono: String,
    val correo: String,
    val contrasena: String,
    val direccion: String? = null
)

data class PerfilRequest(
    val nombre_completo: String? = null,
    val telefono: String? = null
)

data class CambiarContrasenaRequest(
    val contrasena_actual: String,
    val contrasena_nueva: String
)

data class MascotaRequest(
    val nombre: String,
    val especie: String,
    val raza: String? = null,
    val sexo: String,
    val fecha_nacimiento: String? = null,
    val color: String? = null,
    val foto_url: String? = null
)

// --- Lo que se RECIBE en respuestas simples ---

data class LoginResponse(
    val mensaje: String,
    val dueno: Dueno,
    val token: String
)

data class MensajeResponse(
    val mensaje: String
)
