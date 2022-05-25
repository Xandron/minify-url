# Minify Url 
Технічне завдання для Work.ua
## Postman Collection
```{
	"info": {
		"_postman_id": "6efd611d-44e5-42af-b990-8a52e42d8935",
		"name": "Minify Url",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json",
		"_exporter_id": "10166832"
	},
	"item": [
		{
			"name": "http://localhost/{{minificated_url}}",
			"request": {
				"method": "GET",
				"header": [],
				"url": {
					"raw": "http://localhost/{{minificated_url}}",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"{{minificated_url}}"
					]
				},
				"description": "Використання мініфікованого посилання."
			},
			"response": []
		},
		{
			"name": "http://localhost/minification/",
			"request": {
				"method": "POST",
				"header": [],
				"body": {
					"mode": "formdata",
					"formdata": [
						{
							"key": "url",
							"value": "https://google.com.ua",
							"type": "text"
						},
						{
							"key": "expired",
							"value": "30",
							"type": "text"
						},
						{
							"key": "address",
							"value": "test",
							"type": "text",
							"disabled": true
						},
						{
							"key": "astrologer-service-id",
							"value": "8",
							"type": "text",
							"disabled": true
						}
					]
				},
				"url": {
					"raw": "http://localhost/minification/",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"minification",
						""
					]
				},
				"description": "Запит для мініфікації посилання"
			},
			"response": []
		},
		{
			"name": "http://localhost/statistic/all",
			"request": {
				"method": "GET",
				"header": [],
				"url": {
					"raw": "http://localhost:8081/statistic/all",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"port": "8081",
					"path": [
						"statistic",
						"all"
					]
				},
				"description": "Відображення всіх мініфікованих посилання, з сатистикою перходів"
			},
			"response": []
		}
	]
}`