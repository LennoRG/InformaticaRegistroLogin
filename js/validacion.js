$(document).ready(function(){

    $.validator.setDefaults({
        highlight: function(element){
            $(element).next().addClass('glyphicon-remove icono-rojo').removeClass('glyphicon-ok icono-verde');
            $(element).addClass('invalido').removeClass('valido');
        },

        unhighlight: function(element){
            $(element).next().addClass('glyphicon-ok icono-verde').removeClass('glyphicon-remove icono-rojo');
            $(element).addClass('valido').removeClass('invalido');
        }

    });

    $.validator.addMethod('validarNombre',function(value, element){
        return this.optional(element) || /^[a-z\s]{2,45}$/i.test(value);
    }, 'NOMBRES solo puede usar letras y espacios de 2 a 45 caracteres.');

    $.validator.addMethod('validarApellidos',function(value, element){
        return this.optional(element) || /^[a-z\s]{2,45}$/i.test(value);
    }, 'APELLIDOS solo puede usar letras y espacios de 2 a 45 caracteres.');

    $.validator.addMethod('validarUsuario',function(value, element){
        return this.optional(element) || /^[a-z][\w]{2,45}$/i.test(value);
    }, 'USUARIO solo puede usar letras y espacios de 2 a 45 caracteres.');

    $.validator.addMethod('validarEmail',function(value, element){
        return this.optional(element) || /^[a-z]+[\w\.]{2,}@([\w]{2,}\.)+[\w]{2,100}$/i.test(value);
    }, 'EL CORREO ELECTRONICO debe de ser en un formato valido.');

    $.validator.addMethod('validarCarrera',function(value, element){
        return this.optional(element) || /^[a-z\s\.]{2,45}$/i.test(value);
    }, 'CARRERA solo puede usar letras y espacios de 2 a 45 carcteres.');

    $.validator.addMethod('validarNumControl',function(value, element){
        return this.optional(element) || /^[\w]{8}$/.test(value);
    }, 'NUMERO DE CONTROL solo acepta 8 caracteres numericos.');

    $.validator.addMethod('validarPassword',function(value, element){
        return this.optional(element) || /(?=^[\w\!@#\$%\^&\*\?]{8,30}$)(?=(.*\d){2,})(?=(.*[a-z]){2,})(?=(.*[A-Z]){2,})(?=(.*[\|@#\$%\^&\*\?_]){2,})^.*/.test(value);
    }, 'Por favor ingrese un PASSWORD validO. El PASSWORD debe tener por lo menos 2 letras mayusculas, 2 letras minusculas, 2 numero y 2 simbolos.');    
   
    $.validator.addMethod('validarUsuarioOEmail',function(value, element){
        return this.optional(element) || /(?=^[a-z]+[\w@\.{2,50}$])/i.test(value);
    }, 'Use un NOMBRE DE USUARIO o CORREO ELCTRONICO Registrado.');

    

    $("#formulario-registro").validate({
        errorPlacement: function(error, element){
            if(element.attr('type')=='checkbox'){
                error.insertAfter(element.parent('label').parent('div').parent('div'))

            }
            else{
                error.insertAfter(element.parent().parent())

            }

        },
        // errorLabelContainer: '.errores',
        // wrapper: 'li',

        rules:{
            nombre:{
                required: true,
                validarNombre: true
            },
            apellidos:{
                required: true,
                validarApellidos: true
            },
            usuario:{
                required: true,
                validarUsuario: true
            },
            email:{
                required: true,
                validarEmail: true
            },
            carrera:{
                required: true,
                validarCarrera: true 
            },
            numControl:{
                required: true,
                validarNumControl: true
            },
            password:{
                required: true,
                validarPassword: true
            },
            confPass:{
                required: true,
                validarPassword: true,
                equalTo: "#password"
            },
            terminos:{
                required: true
            }

        },
        messages:{
            nombre:{
                required: 'NOMBRE es un campo requerido.',
                validarUsuarioOEmail: true
            },
            apellidos:{
                required: 'APELLIDOS es un campo requerido.'
            },
            usuario:{
                required: 'USUARIO es un campo requerido.'
            },
            email:{
                required: 'CORREO ELECTRONICO es un campo requerido.'
            },
            carrera:{
                required: 'CARRERA es un campo requerido.'
            },
            numControl:{
                required: 'NUMERO DE CONTROL es un campo requerido.'
            },
            password:{
                required: 'CONTRASEÑA es un campo requerido.'
                
            },
            confPass:{
                required: 'CONFIRMAR CONTRASEÑA es un campo requerido.',
                equalTo: 'Las Contraseñas No Coninciden'
                
            },
            terminos:{
                required: 'TERMINOS Y CONDICIONES es un campo requerido'

            }


        }
    });

    
    $("#formulario-login").validate({
        rules:{
            usuarioOEmail:{
                required: true
                
            },
            password:{
                required: true,
                validarPassword: true
            
            }

        },
        messages:{
            usuarioOEmail:{
                required: 'NOMBRE DE USUARIO o CORREO ELECTRONICO es requerido.'
            },
            password:{
                required: 'LA CONTRASEÑA es requerida.'
            },
           


        }
    });

});