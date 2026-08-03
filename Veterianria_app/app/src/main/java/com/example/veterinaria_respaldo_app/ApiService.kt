package com.example.veterinaria_respaldo_app

import retrofit2.Response
import retrofit2.http.*

interface ApiService {

    @POST("duenos")
    suspend fun registrarDueno(@Body body: RegistroDuenoRequest): Response<Dueno>

    @POST("auth/duenos/login")
    suspend fun login(@Body body: LoginRequest): Response<LoginResponse>

    @POST("auth/duenos/logout")
    suspend fun logout(): Response<MensajeResponse>

    @GET("mi-perfil")
    suspend fun getMiPerfil(): Response<Dueno>

    @PUT("mi-perfil")
    suspend fun updateMiPerfil(@Body body: PerfilRequest): Response<Dueno>

    @PUT("mi-perfil/contrasena")
    suspend fun cambiarContrasena(@Body body: CambiarContrasenaRequest): Response<MensajeResponse>

    @GET("mis-mascotas")
    suspend fun getMisMascotas(): Response<List<Mascota>>

    @POST("mis-mascotas")
    suspend fun crearMascota(@Body body: MascotaRequest): Response<Mascota>

    @GET("mis-mascotas/{id}")
    suspend fun getMascota(@Path("id") id: Int): Response<Mascota>

    @PUT("mis-mascotas/{id}")
    suspend fun updateMascota(@Path("id") id: Int, @Body body: MascotaRequest): Response<Mascota>
}
