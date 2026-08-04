package com.example.veterinaria_respaldo_app

object SingletonDeDatos {
    var array_validaciones: ArrayList<String>
    var arraylist_mensajes:ArrayList<String>
    var usuario_por_defecto:String
    var contraseña_por_defecto:String

    var nombre_final_usuario:String

    var telefono_final_usuario:String

    var correo_final_usuario:String

    var direccion_final_usuario:String

    var contraseña_final_usuario:String

    init {
        usuario_por_defecto="RafaelMorenov@gmail.com"
        contraseña_por_defecto="12345"
        arraylist_mensajes= ArrayList()
        arraylist_mensajes.add(0, "Los campos no pueden estar vacios")
        arraylist_mensajes.add(1, "El formato de correo no es valido")
        arraylist_mensajes.add(2, "El formato de telefono no es valido")
        arraylist_mensajes.add(3, "El nombre completo solo puede contener letras y espacios (3 a 100 caracteres)")
        arraylist_mensajes.add(4, "La dirección tiene caracteres no válidos o supera el límite permitido (5 a 100 caracteres)")
        arraylist_mensajes.add(5, "La contraseña debe tener entre 8 y 50 caracteres")
        array_validaciones= ArrayList()
        array_validaciones.add(0, "^[A-Za-z0-9.-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$")
        array_validaciones.add(1, "^871[0-9]{7}$")
        array_validaciones.add(2, "^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+(?: [A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+)*$")
        array_validaciones.add(3, "^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ0-9#°.,\\- ]{5,100}$")

        nombre_final_usuario=""
        telefono_final_usuario=""
        correo_final_usuario=""
        direccion_final_usuario=""
        contraseña_final_usuario=""

    }
}
