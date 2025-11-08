from flask import Flask, render_template, request, redirect, url_for, Response
import mysql.connector
import cv2
from PIL import Image
import numpy as np
import os

app = Flask(__name__)

# Conexión a la base de datos XAMPP
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="Pame0805.",
    database="empleadon"
)

mycursor = mydb.cursor()

# Directorio base de la aplicación
base_dir = os.path.dirname(os.path.abspath(__file__))

# Rutas relativas a los recursos y datos
resources_dir = os.path.join(base_dir, 'resources')
dataset_dir = os.path.join(base_dir, 'dataset')
classifier_path = os.path.join(base_dir, 'classifier.xml')

# Clasificador de rostros
face_cascade_path = os.path.join(resources_dir, 'haarcascade_frontalface_default.xml')
face_classifier = cv2.CascadeClassifier(face_cascade_path)

# <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Generate dataset >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
def generate_dataset(nbr):
    cap = cv2.VideoCapture(0)

    mycursor.execute("SELECT IFNULL(MAX(img_id), 0) FROM img_dataset")
    row = mycursor.fetchone()
    lastid = row[0]

    img_id = lastid
    max_imgid = img_id + 100
    count_img = 0

    while True:
        ret, img = cap.read()
        if ret:
            cropped_img = face_cropped(img)
            if cropped_img is not None:
                count_img += 1
                img_id += 1
                face = cv2.resize(cropped_img, (200, 200))
                face = cv2.cvtColor(face, cv2.COLOR_BGR2GRAY)

                file_name_path = os.path.join(dataset_dir, f"{nbr}.{img_id}.jpg")
                cv2.imwrite(file_name_path, face)
                cv2.putText(face, str(count_img), (50, 50), cv2.FONT_HERSHEY_COMPLEX, 1, (0, 255, 0), 2)

                mycursor.execute("INSERT INTO img_dataset (img_id, img_person) VALUES (%s, %s)", (img_id, nbr))
                mydb.commit()

                frame = cv2.imencode('.jpg', face)[1].tobytes()
                yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

                if cv2.waitKey(1) == 13 or img_id == max_imgid:
                    break
        else:
            print("No se pudo capturar la imagen correctamente.")

    cap.release()
    cv2.destroyAllWindows()

def face_cropped(img):
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    faces = face_classifier.detectMultiScale(gray, 1.3, 5)

    if len(faces) == 0:
        return None
    for (x, y, w, h) in faces:
        cropped_face = img[y:y + h, x:x + w]
    return cropped_face


    cap = cv2.VideoCapture(0)

    mycursor.execute("SELECT IFNULL(MAX(img_id), 0) FROM img_dataset")
    row = mycursor.fetchone()
    lastid = row[0]

    img_id = lastid
    max_imgid = img_id + 100
    count_img = 0

    while True:
        ret, img = cap.read()
        if face_cropped(img) is not None:
            count_img += 1
            img_id += 1
            face = cv2.resize(face_cropped(img), (200, 200))
            face = cv2.cvtColor(face, cv2.COLOR_BGR2GRAY)

            file_name_path = os.path.join(dataset_dir, f"{nbr}.{img_id}.jpg")
            cv2.imwrite(file_name_path, face)
            cv2.putText(face, str(count_img), (50, 50), cv2.FONT_HERSHEY_COMPLEX, 1, (0, 255, 0), 2)

            mycursor.execute("INSERT INTO img_dataset (img_id, img_person) VALUES (%s, %s)", (img_id, nbr))
            mydb.commit()

            frame = cv2.imencode('.jpg', face)[1].tobytes()
            yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

            if cv2.waitKey(1) == 13 or img_id == max_imgid:
                break

    cap.release()
    cv2.destroyAllWindows()

# <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Train Classifier >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
@app.route('/train_classifier/<nbr>')
def train_classifier(nbr):
    path = [os.path.join(dataset_dir, f) for f in os.listdir(dataset_dir)]
    faces = []
    ids = []

    for image in path:
        img = Image.open(image).convert('L')
        imageNp = np.array(img, 'uint8')
        id = int(os.path.split(image)[1].split(".")[1])

        faces.append(imageNp)
        ids.append(id)
    ids = np.array(ids)

    # Train the classifier and save
    clf = cv2.face.LBPHFaceRecognizer_create()
    clf.train(faces, ids)
    clf.write(classifier_path)

    return redirect('/')

# <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Face Recognition >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
def face_recognition():
    def draw_boundary(img, classifier, scaleFactor, minNeighbors, color, text, clf):
        gray_image = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        features = classifier.detectMultiScale(gray_image, scaleFactor, minNeighbors)

        coords = []

        for (x, y, w, h) in features:
            cv2.rectangle(img, (x, y), (x + w, y + h), color, 2)
            id, pred = clf.predict(gray_image[y:y + h, x:x + w])
            confidence = int(100 * (1 - pred / 300))

            mycursor.execute("SELECT b.prs_name "
                                 "FROM img_dataset a "
                                 "LEFT JOIN prs_mstr b ON a.img_person = b.prs_nbr "
                                 "WHERE img_id = %s", (id,))
            s = mycursor.fetchone()
            if s:
                s = ''.join(s)

            if confidence > 70:
                cv2.putText(img, s, (x, y - 5), cv2.FONT_HERSHEY_SIMPLEX, 0.8, color, 1, cv2.LINE_AA)
                # Registrar la asistencia con hora de entrada
                mycursor.execute("INSERT INTO asistencia (idEmpleado, fecha, horaEntrada) VALUES (%s, CURDATE(), CURTIME())", 
                                 (id,))
                mydb.commit()
            else:
                cv2.putText(img, "UNKNOWN", (x, y - 5), cv2.FONT_HERSHEY_SIMPLEX, 0.8, (0, 0, 255), 1, cv2.LINE_AA)

            coords = [x, y, w, h]
        return coords

    def recognize(img, clf, faceCascade):
        coords = draw_boundary(img, faceCascade, 1.1, 10, (255, 255, 0), "Face", clf)
        return img

    faceCascade = cv2.CascadeClassifier(face_cascade_path)
    clf = cv2.face.LBPHFaceRecognizer_create()
    clf.read(classifier_path)

    wCam, hCam = 500, 400

    cap = cv2.VideoCapture(0)
    cap.set(3, wCam)
    cap.set(4, hCam)

    while True:
        ret, img = cap.read()

        if not ret:
            print("No se pudo capturar la imagen correctamente.")
            break

        img = recognize(img, clf, faceCascade)

        frame = cv2.imencode('.jpg', img)[1].tobytes()
        yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

        key = cv2.waitKey(1)
        if key == 27:
            break

    cap.release()
    cv2.destroyAllWindows()


@app.route('/')
def home():
    mycursor.execute("""
        SELECT empleado.idEmpleado, empleado.nombre, empleado.apellido, rol.nombre AS rol 
        FROM empleado 
        JOIN rol ON empleado.idRol = rol.idRol
    """)
    data = mycursor.fetchall()
    return render_template('registrar_asistencia.html', data=data)

@app.route('/vfdataset_page/<prs>')
def vfdataset_page(prs):
    return render_template('gendataset.html', prs=prs)

@app.route('/vidfeed_dataset/<nbr>')
def vidfeed_dataset(nbr):
    # Video streaming route. Put this in the src attribute of an img tag
    return Response(generate_dataset(nbr), mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/video_feed')
def video_feed():
    # Video streaming route. Put this in the src attribute of an img tag
    return Response(face_recognition(), mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/fr_page')
def fr_page():
    return render_template('fr_page.html')

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)




