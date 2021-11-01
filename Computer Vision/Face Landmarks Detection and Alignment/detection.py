import cv2
import dlib
from imutils import face_utils
import numpy as np
from scipy.spatial import Delaunay
import matplotlib.pyplot as plt
from matplotlib import transforms
import os
import math

def load_images_from_folder(folder):
    images = []
    filenames = []
    for filename in os.listdir(folder):
        img = cv2.imread(os.path.join(folder, filename), cv2.IMREAD_COLOR)
        if img is not None:
            images.append(img)
            filenames.append(filename)
    return images, filenames




def facial_landmarks(image):
    # Function to perform facial landmark detection on the whole face

    # Use dlib 68 & 81 to predict landmarks points coordinates
    detector = dlib.get_frontal_face_detector()
    predictor68 = dlib.shape_predictor('../shape_predictor_68_face_landmarks.dat')
    predictor81 = dlib.shape_predictor('../shape_predictor_81_face_landmarks.dat')
    
    # Grayscale image
    try:
        grayscale_image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    except:
        grayscale_image = image
    
    # array of rectangles surrounding faces detected
    rectangles = detector(grayscale_image, 1)

    # If at least one face is detected   
    if len(rectangles) > 0:
        # Get 68 landmark points
        faceLandmarks = predictor68(grayscale_image, rectangles[0])
        faceLandmarks = face_utils.shape_to_np(faceLandmarks)
        
        
        # Get 81 landmark points
        foreheadLandmarks = predictor81(grayscale_image, rectangles[0])
        foreheadLandmarks = face_utils.shape_to_np(foreheadLandmarks)
        
        # Get 68 point from -68- predictor (higher accuracy) + forehead from -81- predictor
        fullFacePoints = np.concatenate((faceLandmarks, foreheadLandmarks[68:]))
        
        
        return fullFacePoints
    # No faces found
    else:
        return None


def align_face(image, eyePoints):
  # Function to rotate image to align the face
  # Get left eye & right eye coordinates
  leftEyeX,leftEyeY = eyePoints[0]
  rightEyeX, rightEyeY = eyePoints[1]
  
  # Calculate angle of rotation & origin point
  angle = math.atan( (leftEyeY - rightEyeY) / (leftEyeX - rightEyeX) ) * (180/math.pi)
  origin_point = tuple(np.array(image.shape[1::-1]) / 2)
  
  # Rotate using rotation matrix
  rot_mat = cv2.getRotationMatrix2D(origin_point, angle, 1.0)
  result = cv2.warpAffine(image, rot_mat, image.shape[1::-1], flags=cv2.INTER_LINEAR)
  return result


def delaunayOnPlane(facial_points):
    # Function to visualize delaunay triangulation on matplotlib
    tri = Delaunay(facial_points)
    rot = transforms.Affine2D().rotate_deg(180)
    base = plt.gca().transData
    plt.gca().invert_xaxis()
    plt.triplot(facial_points[:,0], facial_points[:,1], tri.simplices.copy(), transform=rot+base)
    plt.plot(facial_points[:,0], facial_points[:,1], 'o', transform=rot+base)
    plt.show()
    

def drawPoints(image, points, pointColor=(255,255,255), lineColor=(255,255,255), pointThickness=6, lineThickness=1):
    # Function to draw points on facial features
    for i in points:
        x,y = i
        image = cv2.circle(image, (x,y), radius=0, color=pointColor, thickness=pointThickness)

    return image

def main():
    # Move opencv window
    winname = "Test"
    cv2.namedWindow(winname)
    cv2.moveWindow(winname, 40,30) 
    
    # Capture all images in current folder & their names
    images, filesnames = load_images_from_folder('.')
    
    # Detect & Visualize each image
    for i in range(0,len(images)):
        originalImage = images[i]
        cv2.imshow(winname, originalImage) 
        cv2.waitKey(0)
    
        landmarks = facial_landmarks(originalImage)
        
        if landmarks is not None:
            eyePoints = (landmarks[39], landmarks[42]) # used for rotation
            
    
            image = drawPoints(originalImage, landmarks)

            image = align_face(image, eyePoints)

            cv2.imshow(winname, image) 
            cv2.waitKey(0)
    
            delaunayOnPlane(landmarks) # draw Delaunay Triangulation on a plane
            
            #cv2.imwrite(filesnames[i].replace('sample', 'output'), image)

main()
