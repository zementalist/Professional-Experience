import json
import numpy as np
import cv2
import io
from django.core import serializers
from django.http import HttpResponse, JsonResponse
from django.shortcuts import render, redirect, get_object_or_404
import base64
import os
import dlib
from imutils import face_utils
import math

from .detection import *
from .geometry import *
from .feature_analysis import *
# Create your views here.

def roundingVals_toTwoDeci(y):
    for k, v in y.items():
        v = round(v, 3)
        print(v)
        y[k] = float(v)
    return y

def analyze(request):
    if request.method == 'POST':
        myfile = request.FILES['file'].file.read()
        nparr = np.fromstring(myfile, np.uint8)
        input_image = cv2.imdecode(nparr, cv2.IMREAD_COLOR) # cv2.IMREAD_COLOR in OpenCV 3.1

        # Let's have a ****
        originalImage = input_image

        # Detect eyes landmarks, to align the face later
        eyePoints = facial_landmarks(originalImage, eyeOnlyMode=True)
        
        if eyePoints is not None:
            
            # Align face and redetect landmarks
            image = align_face(originalImage, eyePoints)
            improved_landmarks = facial_landmarks(image, allowEnhancement=True)

            # Draw landmarks points (just for view)
 
            # Extract the face from the image & resize it
            # image = drawPoints(image, improved_landmarks)
            # faceOnlyImage = cropFullFace(image, improved_landmarks)

            #cv2.imwrite(filesnames[i].replace('sample', 'output'), image)
            
            # Scale points coordinates
#            points = scale_points(originalImage.shape, faceOnlyImage.shape, improved_landmarks)
    
            # Measures features
            measures, graphical_pts = measure_features(improved_landmarks)
            
            image = lineFeatures(image, graphical_pts)

            measures = roundingVals_toTwoDeci(measures)
            print(measures)


            ret, jpeg = cv2.imencode('.jpg', image)
            image_bytes = jpeg.tobytes()
            output_image_html = f"""<img src='data:image/png;base64,{base64.b64encode(image_bytes).decode()}' class='demo-img'/>"""

            return JsonResponse({'image':output_image_html, 'measurements': measures})


        else:
            return JsonResponse({'error':'No faces detected!'})