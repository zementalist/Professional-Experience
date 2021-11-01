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
from .extractor import *
# Create your views here.


def extract(request):
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

            ret, jpeg = cv2.imencode('.jpg', image)
            image_bytes = jpeg.tobytes()
            output_image_html = "<img class='demo-img' src='data:image/png;base64," + base64.b64encode(image_bytes).decode() + "'/>"

            # Extract feature
            options = ['all']
            features = face_parts_imgs(image, improved_landmarks, options)
            feature_images = {}
            for key in features:
                ret, jpeg = cv2.imencode('.jpg', features[key])
                image_bytes = jpeg.tobytes()
                html_class = 'extractor-img'
                output_html = f"<img class='{html_class}' src='data:image/png;base64,{base64.b64encode(image_bytes).decode()}'/>"
                feature_images[key] = output_html
        
            return JsonResponse({'image':output_image_html,'features': feature_images})
        
        else:
            return JsonResponse({'error':'No faces detected!'})