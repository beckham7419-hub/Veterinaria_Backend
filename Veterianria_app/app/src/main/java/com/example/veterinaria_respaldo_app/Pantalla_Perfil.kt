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

lateinit var boton_back_perf: CardView
lateinit var nombre_dueno: TextView
lateinit var correo_dueno: TextView
lateinit var telefono_dueno: TextView
lateinit var direccion_dueno: TextView
lateinit var editar_perfil: Button
lateinit var boton_cerrar_sesion: Button

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
        boton_back_perf=findViewById(R.id.boton_back_perf)
        nombre_dueno=findViewById(R.id.nombre_dueno)
        correo_dueno=findViewById(R.id.correo_dueno)
        telefono_dueno=findViewById(R.id.telefono_dueno)
        direccion_dueno=findViewById(R.id.direccion_dueno)
        editar_perfil=findViewById(R.id.editar_perfil)
        boton_cerrar_sesion=findViewById(R.id.boton_cerrar_sesion)


        boton_back_perf.setOnClickListener {
            finish()
        }

        boton_cerrar_sesion.setOnClickListener {
            boton_cerrar_sesion.isEnabled = false
            lifecycleScope.launch {
                try {
                    RetrofitClient.instance.logout()
                } catch (e: Exception) {
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
