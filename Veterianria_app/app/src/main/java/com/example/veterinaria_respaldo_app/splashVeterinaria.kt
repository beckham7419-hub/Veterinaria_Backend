package com.example.veterinaria_respaldo_app

import android.content.Intent
import android.os.Bundle
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import androidx.lifecycle.lifecycleScope
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

class splashVeterinaria : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_splash_veterinaria)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }

        lifecycleScope.launch {
            val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
            val token = prefs.getString("token", null)

            delay(5000)

            val destino = if (token.isNullOrEmpty()) {
                menuLoginVeterinaria::class.java
            } else {
                RetrofitClient.setToken(token)
                val sesionValida = try {
                    val response = RetrofitClient.instance.getMiPerfil()
                    if (response.isSuccessful) {
                        response.body()?.let { dueno ->
                            SingletonDeDatos.nombre_final_usuario = dueno.nombre_completo
                            SingletonDeDatos.correo_final_usuario = dueno.correo
                        }
                    }
                    response.isSuccessful
                } catch (e: Exception) {
                    false
                }

                if (sesionValida) {
                    MainActivity::class.java
                } else {
                    prefs.edit().remove("token").apply()
                    RetrofitClient.setToken(null)
                    menuLoginVeterinaria::class.java
                }
            }

            startActivity(Intent(this@splashVeterinaria, destino))
            finish()
        }
    }
}
