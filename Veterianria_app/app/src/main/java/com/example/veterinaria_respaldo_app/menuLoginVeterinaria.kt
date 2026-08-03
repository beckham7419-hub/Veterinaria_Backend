package com.example.veterinaria_respaldo_app

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat

lateinit var boton_iniciosesion: Button
lateinit var boton_registrarsa: Button
class menuLoginVeterinaria : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_menu_login_veterinaria)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }
        boton_iniciosesion =findViewById(R.id.boton_iniciosesion)
        boton_registrarsa =findViewById(R.id.boton_registrarsa)

       boton_iniciosesion.setOnClickListener {
            startActivity(Intent(this@menuLoginVeterinaria, Iniciarsesion::class.java ))
        }
       boton_registrarsa.setOnClickListener {
            startActivity(Intent(this@menuLoginVeterinaria, Registrarse::class.java ))
        }
    }
}
