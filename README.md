#Modulo de Actaas de reunion

##actas 

###creacion
las sigueites rutas y ejemplos hacen parate del Web Service
```
https://pruebasim.imaginacolombia.com/api/iact/acts

#valores a enviar

{
"attributes":{
	"es":{
		"title":"acta 0001",
		"activities":["inicio de Reunion","lectura del acta anterior","discucion del tema principla"],
		"description": "se incia la reunion alas 11:00 am del 05 de junio de 2019 y se hacen los actgos protocoalarios de incio de reunion, se da letura la acta anteriror y se discute el thema principal de esta, siendo las 12::00 m se da por terminada la reunion "
	},
	"city_id":25,
	"address":{"address":"calle 29 # 7-54 ibague","longitude":"75.54545","latitude":"4.355445"},
	"user_id":1,
	"phone":"5732154588"
	}
```

###listar

``https://pruebasim.imaginacolombia.com/api/iact/acts``

filtros
```json
filter={}
```