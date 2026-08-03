package com.example.veterinaria_respaldo_app

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import com.google.android.material.textfield.TextInputEditText
import com.google.android.material.textfield.TextInputLayout
import kotlin.collections.get

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
   registrarse_btn.setOnClickListener {
            if( input_edittext_nombre_usuario.text.toString().isEmpty()||
              input_edittext_telefono.text.toString().isEmpty()||
               input_edittext_correo.text.toString().isEmpty()||
               input_edittext_direccion.text.toString().isEmpty()||
               input_edittext_password.text.toString().isEmpty()){
                showMessage(0)
            }else if(!input_edittext_correo.text.toString().matches(SingletonDeDatos.array_validaciones.get(0).toRegex())){
                showMessage(1)
            }
            else if(!input_edittext_telefono.text.toString().matches(SingletonDeDatos.array_validaciones.get(1).toRegex())){
                showMessage(2)
            }else{
                SingletonDeDatos.nombre_final_usuario=
                    input_edittext_nombre_usuario.text.toString()
                SingletonDeDatos.telefono_final_usuario=
                   input_edittext_telefono.text.toString()
                SingletonDeDatos.correo_final_usuario=
                  input_edittext_correo.text.toString()
                SingletonDeDatos.direccion_final_usuario=
                  input_edittext_direccion.text.toString()
                SingletonDeDatos.contraseña_final_usuario=
                  input_edittext_password.text.toString()
                startActivity(Intent(this@Registrarse, MainActivity::class.java))
                finish();
            }

            if(input_edittext_correo.text.toString().matches(SingletonDeDatos.array_validaciones.get(0).toRegex())){
             input_layout_correo.error=null
            }else{
               input_layout_correo.error="Formato de correo invalido"
            }
            if(input_edittext_telefono.text.toString().matches(SingletonDeDatos.array_validaciones.get(1).toRegex())){
                input_layout_telefono.error=null
            }else{
               input_layout_telefono.error="Formato de telefono invalido"
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
