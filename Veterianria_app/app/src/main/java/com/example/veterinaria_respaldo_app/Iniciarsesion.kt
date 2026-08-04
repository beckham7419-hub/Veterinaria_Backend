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
import androidx.lifecycle.lifecycleScope
import com.google.android.material.textfield.TextInputEditText
import com.google.android.material.textfield.TextInputLayout
import kotlinx.coroutines.launch

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
            val ime = insets.getInsets(WindowInsetsCompat.Type.ime())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, maxOf(systemBars.bottom, ime.bottom))
            insets
        }

      input_layout_iniciars =findViewById(R.id.input_layout_iniciars)
      input_edittext_iniciars =findViewById(R.id.input_edittext_iniciars)
      input_layout_password_in =findViewById(R.id.input_layout_password_in)
      input_edittext_password_in =findViewById(R.id.input_edittext_password_in)
      iniciarsesion =findViewById(R.id.iniciarsesion)
       boton_back =findViewById(R.id.boton_back)

      iniciarsesion.setOnClickListener {
            val correo = input_edittext_iniciars.text.toString()
            val contrasena = input_edittext_password_in.text.toString()

            if(correo.isEmpty() || contrasena.isEmpty()){
                showMessage(0)
            }else if(!correo.matches(SingletonDeDatos.array_validaciones.get(0).toRegex())){
                showMessage(1)
            }else{
                lifecycleScope.launch {
                    try {
                        val response = RetrofitClient.instance.login(LoginRequest(correo, contrasena))

                        if (response.isSuccessful && response.body() != null) {
                            val body = response.body()!!
                            RetrofitClient.setToken(body.token)
                            getSharedPreferences("app_prefs", MODE_PRIVATE)
                                .edit()
                                .putString("token", body.token)
                                .apply()

                            input_layout_iniciars.error = null
                            input_layout_password_in.error = null

                            SingletonDeDatos.nombre_final_usuario = body.dueno.nombre_completo
                            SingletonDeDatos.correo_final_usuario = body.dueno.correo

                            startActivity(Intent(this@Iniciarsesion, MainActivity::class.java))
                            finish()
                        } else {
                            input_layout_iniciars.error = "Correo o contraseña incorrectos"
                            input_layout_password_in.error = "Correo o contraseña incorrectos"
                        }
                    } catch (e: Exception) {
                        input_layout_password_in.error = "Error de conexion: ${e.message}"
                    }
                }
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
