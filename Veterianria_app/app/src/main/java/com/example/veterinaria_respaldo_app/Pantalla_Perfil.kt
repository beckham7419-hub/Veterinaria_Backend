package com.example.veterinaria_respaldo_app

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import android.widget.TextView
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import androidx.lifecycle.lifecycleScope
import kotlinx.coroutines.launch

class Pantalla_Perfil : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_pantalla_perfil)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }

        val botonBack = findViewById<CardView>(R.id.boton_more_perf)
        val textoNombre = findViewById<TextView>(R.id.texto_nombre_perfil)
        val textoCorreo = findViewById<TextView>(R.id.texto_correo_perfil)
        val botonCerrarSesion = findViewById<Button>(R.id.boton_cerrar_sesion)

        textoNombre.text = SingletonDeDatos.nombre_final_usuario
        textoCorreo.text = SingletonDeDatos.correo_final_usuario

        botonBack.setOnClickListener {
            finish()
        }

        botonCerrarSesion.setOnClickListener {
            botonCerrarSesion.isEnabled = false
            lifecycleScope.launch {
                try {
                    RetrofitClient.instance.logout()
                } catch (e: Exception) {
                    // Aunque falle la petición, la sesión se cierra localmente igual.
                }
                cerrarSesionLocal()
            }
        }
    }

    private fun cerrarSesionLocal() {
        getSharedPreferences("app_prefs", MODE_PRIVATE)
            .edit()
            .remove("token")
            .apply()
        RetrofitClient.setToken(null)

        val intent = Intent(this@Pantalla_Perfil, menuLoginVeterinaria::class.java)
        intent.flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK
        startActivity(intent)
        finish()
    }
}
