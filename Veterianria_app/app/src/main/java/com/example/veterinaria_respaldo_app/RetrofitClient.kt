package com.example.veterinaria_respaldo_app

import okhttp3.Interceptor
import okhttp3.OkHttpClient
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

object RetrofitClient {
    private var token: String? = null

    fun setToken(t: String?) { token = t }

    private val authInterceptor = Interceptor { chain ->
        val request = chain.request().newBuilder()
        token?.let { request.addHeader("Authorization", "Bearer $it") }
        chain.proceed(request.build())
    }

    private val client = OkHttpClient.Builder()
        .addInterceptor(authInterceptor)
        .build()

    val instance: ApiService by lazy {
        Retrofit.Builder()
            .baseUrl("http://192.168.1.3:8000/api/")
            .client(client)
            .addConverterFactory(GsonConverterFactory.create())
            .build()
            .create(ApiService::class.java)
    }
}
