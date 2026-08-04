package com.example.veterinaria_respaldo_app

import android.content.Intent
import android.os.Build
import android.os.Bundle
import android.util.Log
import android.widget.LinearLayout
import android.widget.PopupMenu
import android.widget.Toast
import androidx.activity.enableEdgeToEdge
import androidx.annotation.RequiresApi
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import  com.android.volley.Request
import com.android.volley.VolleyLog.d
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley

lateinit var boton_more_options: CardView

lateinit var tap_inicio: LinearLayout

lateinit var tap_citas: LinearLayout

lateinit var tap_mascotas: LinearLayout

class MainActivity : AppCompatActivity() {
    @RequiresApi(Build.VERSION_CODES.UPSIDE_DOWN_CAKE)
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }
        boton_more_options=findViewById(R.id.boton_more_options)
        tap_inicio=findViewById(R.id.tap_inicio)
        tap_citas=findViewById(R.id.tap_citas)
        tap_mascotas=findViewById(R.id.tap_mascotas)

        boton_more_options.setOnClickListener {view ->

            val popup = PopupMenu(this, view)
            popup.menuInflater.inflate(R.menu.menu_opciones, popup.menu)

            popup.setOnMenuItemClickListener {
                    menuItem ->
                when (menuItem.itemId) {
                    R.id.opcion_perfil -> {
                        Toast.makeText(this, "Perfil seleccionado", Toast.LENGTH_SHORT).show()
                        startActivity(Intent(this@MainActivity, Pantalla_Perfil::class.java))
                        true
                    }
                    R.id.opcion_historial -> {
                        Toast.makeText(this, "Historial Clínico seleccionado", Toast.LENGTH_SHORT).show()
                        startActivity(Intent(this@MainActivity, Pantalla_Historial_Clinico::class.java))
                        true
                    }
                    else -> false
                    }
            }
            popup.show()
        }
        tap_citas.setOnClickListener {
            val intent = Intent(this, Pantalla_Citas::class.java)
            intent.flags = Intent.FLAG_ACTIVITY_REORDER_TO_FRONT
            startActivity(intent)
            @Suppress("DEPRECATION")
            overridePendingTransition(0, 0)
        }

        tap_mascotas.setOnClickListener {
            val intent = Intent(this, Pantalla_Macotas::class.java)
            intent.flags = Intent.FLAG_ACTIVITY_REORDER_TO_FRONT
            startActivity(intent)
            @Suppress("DEPRECATION")
            overridePendingTransition(0, 0)
        }
        fun cargarApiVeterinaria(){
            val url="http://10.0.2.2:8000/api/"
            val queue= Volley.newRequestQueue(this)

            val StringRequest= StringRequest(
                Request.Method.GET,
                url,
                {
                        respuesta->
                    Log.v("TAB", "Ok"+respuesta)
                    SingletonDeDatos.respuesta_server=respuesta
                    startActivity(Intent(this@MainActivity, Pantalla_Perfil::class.java))
                },
                {
                        error->
                    Log.v("TAB", "No hubo respuesta"+error)
                }

            )
            queue.add(StringRequest)
        }
    }
}
