package com.example.veterinaria_respaldo_app

import android.content.Intent
import android.os.Bundle
import android.widget.LinearLayout
import android.widget.PopupMenu
import android.widget.Toast
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat

lateinit var boton_more_options2: CardView

lateinit var tap_inicio2: LinearLayout

lateinit var tap_citas2: LinearLayout

lateinit var tap_mascotas2: LinearLayout

class Pantalla_Citas : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_pantalla_citas)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }
        boton_more_options2 = findViewById(R.id.boton_more_options2)
        tap_inicio2 = findViewById(R.id.tap_inicio2)
        tap_citas2 = findViewById(R.id.tap_citas2)
        tap_mascotas2 = findViewById(R.id.tap_mascotas2)

        boton_more_options2.setOnClickListener { view ->

            val popup = PopupMenu(this, view)
            popup.menuInflater.inflate(R.menu.menu_opciones, popup.menu)

            popup.setOnMenuItemClickListener { menuItem ->
                when (menuItem.itemId) {
                    R.id.opcion_perfil -> {
                        Toast.makeText(this, "Perfil seleccionado", Toast.LENGTH_SHORT).show()
                        startActivity(Intent(this@Pantalla_Citas, Pantalla_Perfil::class.java))
                        true
                    }

                    R.id.opcion_historial -> {
                        Toast.makeText(this, "Historial Clínico seleccionado", Toast.LENGTH_SHORT)
                            .show()
                        startActivity(
                            Intent(
                                this@Pantalla_Citas,
                                Pantalla_Historial_Clinico::class.java
                            )
                        )
                        true
                    }

                    else -> false
                }
            }
            popup.show()
        }
        tap_mascotas2.setOnClickListener {
            val intent = Intent(this, Pantalla_Macotas::class.java)
            intent.flags = Intent.FLAG_ACTIVITY_REORDER_TO_FRONT
            startActivity(intent)
            @Suppress("DEPRECATION")
            overridePendingTransition(0, 0)
        }

        tap_inicio2.setOnClickListener {
            val intent = Intent(this, MainActivity::class.java)
            intent.flags = Intent.FLAG_ACTIVITY_REORDER_TO_FRONT
            startActivity(intent)
            @Suppress("DEPRECATION")
            overridePendingTransition(0, 0)
        }
    }
}
