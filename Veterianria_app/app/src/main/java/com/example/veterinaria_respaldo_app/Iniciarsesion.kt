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

lateinit var input_layout_iniciars: TextInputLayout
lateinit var input_edittext_iniciars: TextInputEditText
lateinit var input_layout_password_in: TextInputLayout
lateinit var input_edittext_password_in: TextInputEditText
lateinit var iniciarsesion: Button
lateinit var boton_back: CardView
class Iniciarsesion : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_iniciarsesion)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }

      input_layout_iniciars =findViewById(R.id.input_layout_iniciars)
      input_edittext_iniciars =findViewById(R.id.input_edittext_iniciars)
      input_layout_password_in =findViewById(R.id.input_layout_password_in)
      input_edittext_password_in =findViewById(R.id.input_edittext_password_in)
      iniciarsesion =findViewById(R.id.iniciarsesion)
       boton_back =findViewById(R.id.boton_back)

      iniciarsesion.setOnClickListener {
            if(input_edittext_iniciars.text.toString().isEmpty()|| input_edittext_password_in.text.toString().isEmpty()){
                showMessage(0)
            }else if(!input_edittext_iniciars.text.toString().matches(SingletonDeDatos.array_validaciones.get(0).toRegex())){
                showMessage(1)
            }else if(input_edittext_iniciars.text.toString().contentEquals(SingletonDeDatos.usuario_por_defecto)&& input_edittext_password_in.text.toString().contentEquals(
                    SingletonDeDatos.contraseña_por_defecto)){
                SingletonDeDatos.nombre_final_usuario=
                  input_edittext_iniciars.text.toString()
                SingletonDeDatos.contraseña_final_usuario=
                  input_edittext_password_in.text.toString()
                startActivity(Intent(this@Iniciarsesion, MainActivity2iniciarsesion::class.java))
                finish();

            }
            if(input_edittext_iniciars.text.contentEquals(SingletonDeDatos.usuario_por_defecto)){
              input_layout_iniciars.error=null
            }else{
               input_layout_iniciars.error="Usuario incorrecto"
            }
            if(input_edittext_password_in.text.contentEquals(SingletonDeDatos.contraseña_por_defecto)){
               input_layout_password_in.error=null
            }else{
                input_layout_password_in.error="Contraseña incorrecta"
            }
        }

       boton_back.setOnClickListener {
            startActivity(Intent(this@Iniciarsesion, menuLoginVeterinaria::class.java))
            finish()
        }

    }
    fun showMessage(index:Int){
        var builder = AlertDialog.Builder(this)
        builder.setMessage(SingletonDeDatos.arraylist_mensajes.get(index))
        builder.setCancelable(false)
        builder.setIcon(R.drawable.baseline_email_24)
        builder.setPositiveButton("Ok"){dialog, which->dialog.dismiss()}
        var dialog=builder.create()
        dialog.show()
    }
}
