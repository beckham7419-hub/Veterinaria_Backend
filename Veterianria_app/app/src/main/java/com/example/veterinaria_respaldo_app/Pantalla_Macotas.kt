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

lateinit var boton_more_options3: CardView

lateinit var tap_inicio3: LinearLayout

lateinit var tap_citas3: LinearLayout

lateinit var tap_mascotas3: LinearLayout
class Pantalla_Macotas : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_pantalla_macotas)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }
        boton_more_options3 = findViewById(R.id.boton_more_options3)
        tap_inicio3 = findViewById(R.id.tap_inicio3)
        tap_citas3 = findViewById(R.id.tap_citas3)
        tap_mascotas3 = findViewById(R.id.tap_mascotas3)

        boton_more_options3.setOnClickListener { view ->

            val popup = PopupMenu(this, view)
            popup.menuInflater.inflate(R.menu.menu_opciones, popup.menu)

            popup.setOnMenuItemClickListener { menuItem ->
                when (menuItem.itemId) {
                    R.id.opcion_perfil -> {
                        Toast.makeText(this, "Perfil seleccionado", Toast.LENGTH_SHORT).show()
                        startActivity(Intent(this@Pantalla_Macotas, Pantalla_Perfil::class.java))
                        true
                    }

                    R.id.opcion_historial -> {
                        Toast.makeText(this, "Historial Clínico seleccionado", Toast.LENGTH_SHORT)
                            .show()
                        startActivity(
                            Intent(
                                this@Pantalla_Macotas,
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
        tap_citas3.setOnClickListener {
            val intent = Intent(this, Pantalla_Citas::class.java)
            intent.flags = Intent.FLAG_ACTIVITY_REORDER_TO_FRONT
            startActivity(intent)
            @Suppress("DEPRECATION")
            overridePendingTransition(0, 0)
        }

        tap_inicio3.setOnClickListener {
            val intent = Intent(this, MainActivity::class.java)
            intent.flags = Intent.FLAG_ACTIVITY_REORDER_TO_FRONT
            startActivity(intent)
            @Suppress("DEPRECATION")
            overridePendingTransition(0, 0)
        }
    }
}
