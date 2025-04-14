import os
import uuid
from werkzeug.utils import secure_filename
from flask import Flask, request, jsonify, send_from_directory
from flask_cors import CORS
import tensorflow as tf
from tensorflow.keras.preprocessing import image
import numpy as np
from PIL import Image
import mysql.connector
from datetime import datetime

# Initialize Flask app
app = Flask(__name__)
CORS(app)

# Folder to save uploaded images
UPLOAD_FOLDER = os.path.join('static', 'uploads')
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

# Ensure the upload folder exists
if not os.path.exists(UPLOAD_FOLDER):
    os.makedirs(UPLOAD_FOLDER)

# Load the AI model
model = tf.keras.models.load_model('food_classification_model.keras')
class_names = ['Cendol', 'Ketupat', 'Laksa', 'Nasi Lemak']

# DB connection
def get_db_connection():
    return mysql.connector.connect(
        host='localhost',
        user='root',
        password='',
        database='bitescan'
    )

# Predict function
def predict_food(img):
    img = img.resize((224, 224))
    img_array = np.array(img) / 255.0
    img_array = np.expand_dims(img_array, axis=0)
    predictions = model.predict(img_array)
    predicted_class = class_names[np.argmax(predictions)]
    predicted_probability = float(np.max(predictions))
    return predicted_class, predicted_probability

# Serve image files
@app.route('/uploads/<filename>')
def uploaded_file(filename):
    return send_from_directory(app.config['UPLOAD_FOLDER'], filename)

@app.route('/')
def home():
    return 'Welcome to the BiteScan API! Use the /predict endpoint to make predictions.'

# Prediction route
@app.route('/predict', methods=['POST'])
def predict():
    if 'file' not in request.files:
        return jsonify({'error': 'No file uploaded'}), 400

    file = request.files['file']
    try:
        # ✅ Generate a unique filename
        ext = os.path.splitext(file.filename)[1]  # Get the file extension (e.g. '.jpg')
        unique_filename = f"{uuid.uuid4().hex}{ext}"  # Example: 'a8b1c2d3e4.jpg'

        image_path = os.path.join(app.config['UPLOAD_FOLDER'], unique_filename)
        file.save(image_path)

        img = Image.open(image_path)
        predicted_class, confidence = predict_food(img)
        # Database interaction
        conn = get_db_connection()
        cursor = conn.cursor()
        cursor.execute("SELECT calories FROM food_info WHERE food_name = %s", (predicted_class,))
        result = cursor.fetchone()
        calories = result[0] if result else 'Not found'

         # ✅ Save meal with unique image filename
        cursor.execute("""
            INSERT INTO meal_history (food_name, calories, image_path, timestamp)
            VALUES (%s, %s, %s, %s)
        """, (predicted_class, calories, unique_filename, datetime.now()))
        conn.commit()
        cursor.close()
        conn.close()

        return jsonify({
            'food_name': predicted_class,
            'calories': calories,
            'confidence': confidence,
            'image_path': unique_filename  # ✅ Return the new filename
        })

    except Exception as e:
        print("Error:", str(e))
        return jsonify({'error': str(e)}), 500

# Run the server
if __name__ == '__main__':
    app.run(debug=True)
