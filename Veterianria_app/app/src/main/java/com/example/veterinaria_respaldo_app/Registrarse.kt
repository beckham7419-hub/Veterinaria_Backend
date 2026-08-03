package com.example.veterinaria_respaldo_app

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import android.widget.CheckBox
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import androidx.lifecycle.lifecycleScope
import com.google.android.material.textfield.TextInputEditText
import com.google.android.material.textfield.TextInputLayout
import kotlin.collections.get
import kotlinx.coroutines.launch

lateinit var input_layout_nombre_usuario: TextInputLayout
lateinit var input_edittext_nombre_usuario: TextInputEditText
lateinit var input_layout_telefono: TextInputLayout
lateinit var input_edittext_telefono: TextInputEditText
lateinit var input_layout_correo: TextInputLayout
lateinit var input_edittext_correo: TextInputEditText
lateinit var input_layout_direccion: TextInputLayout
lateinit var input_edittext_direccion: TextInputEditText
lateinit var input_layout_password: TextInputLayout
lateinit var input_edittext_password: TextInputEditText

lateinit var cbTerms: CheckBox

lateinit var registrarse_btn: Button
lateinit var boton_back2: CardView

class Registrarse : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_registrarse)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }
        input_layout_nombre_usuario =findViewById(R.id.input_layout_nombre_usuario)
        input_edittext_nombre_usuario =findViewById(R.id.input_edittext_nombre_usuario)
        input_layout_telefono =findViewById(R.id.input_layout_telefono)
        input_edittext_telefono =findViewById(R.id.input_edittext_telefono)
        input_layout_correo =findViewById(R.id.input_layout_correo)
        input_edittext_correo =findViewById(R.id.input_edittext_correo)
        input_layout_direccion =findViewById(R.id.input_layout_direccion)
        input_edittext_direccion =findViewById(R.id.input_edittext_direccion)
        input_layout_password =findViewById(R.id.input_layout_password)
        input_edittext_password =findViewById(R.id.input_edittext_password)
        registrarse_btn =findViewById(R.id.registrarse_btn)
        boton_back2 =findViewById(R.id.boton_back2)
        cbTerms=findViewById(R.id.cbTerms)

   registrarse_btn.setOnClickListener {
       input_layout_correo.error = null
       input_layout_telefono.error = null

            val nombre = input_edittext_nombre_usuario.text.toString()
            val telefono = input_edittext_telefono.text.toString()
            val correo = input_edittext_correo.text.toString()
            val direccion = input_edittext_direccion.text.toString()
            val contrasena = input_edittext_password.text.toString()

       if (nombre.isEmpty() || telefono.isEmpty() || correo.isEmpty() || direccion.isEmpty() || contrasena.isEmpty()) {
           showMessage(0)
           return@setOnClickListener
       }

       if (!correo.matches(SingletonDeDatos.array_validaciones[0].toRegex())) {
           input_layout_correo.error = "Formato de correo inválido"
           showMessage(1)
           return@setOnClickListener
       }

       if (!telefono.matches(SingletonDeDatos.array_validaciones[1].toRegex())) {
           input_layout_telefono.error = "Formato de teléfono inválido"
           showMessage(2)
           return@setOnClickListener
       }

       if (!cbTerms.isChecked) {
           AlertDialog.Builder(this)
               .setMessage("Debes aceptar los términos y condiciones para continuar.")
               .setPositiveButton("Ok") { dialog, _ -> dialog.dismiss() }
               .show()
           return@setOnClickListener
       }

                lifecycleScope.launch {
                    try {
                        val response = RetrofitClient.instance.registrarDueno(
                            RegistroDuenoRequest(
                                nombre_completo = nombre,
                                telefono = telefono,
                                correo = correo,
                                contrasena = contrasena,
                                direccion = direccion
                            )
                        )

                        if (response.isSuccessful) {
                            SingletonDeDatos.nombre_final_usuario = nombre
                            SingletonDeDatos.telefono_final_usuario = telefono
                            SingletonDeDatos.correo_final_usuario = correo
                            SingletonDeDatos.direccion_final_usuario = direccion

                            startActivity(Intent(this@Registrarse, Iniciarsesion::class.java))
                            finish()
                        } else if (response.code() == 422) {
                            input_layout_correo.error = "Ese correo ya esta registrado"
                        } else {
                            AlertDialog.Builder(this@Registrarse)
                                .setMessage("Error del servidor (código ${response.code()}). Intenta de nuevo.")
                                .setPositiveButton("Ok") { d, _ -> d.dismiss() }
                                .show()
                        }
                    } catch (e: Exception) {
                        e.printStackTrace()
                        AlertDialog.Builder(this@Registrarse)
                            .setMessage("No se pudo conectar al servidor. Revisa tu conexión.")
                            .setPositiveButton("Ok") { d, _ -> d.dismiss() }
                            .show()
                    }
                }
            }




      boton_back2.setOnClickListener {
            startActivity(Intent(this@Registrarse, menuLoginVeterinaria::class.java))
            finish()
        }

    }

    fun showMessage(index:Int) {
        var builder = AlertDialog.Builder(this)
        builder.setMessage(SingletonDeDatos.arraylist_mensajes.get(index))
        builder.setCancelable(false)
        builder.setIcon(R.drawable.baseline_email_24)
        builder.setPositiveButton("Ok") { dialog, which -> dialog.dismiss() }
        var dialog = builder.create()
        dialog.show()
    }
}
