from django.shortcuts import render
from .models import VAK
import re
import os
import pickle
from datetime import datetime
# Create your views here.
static_files_path = os.path.join(os.path.dirname(os.path.dirname(__file__)),'static/classifier/')
# Load from file


 

def read_pickle_object(file_path):
    with open(file_path, 'rb') as file:
        pickle_obj = pickle.load(file)
    return pickle_obj

def clean(text):
    # Function to preprocess text
    stopwords = read_pickle_object(static_files_path + 'stopwords.pkl')
    ps = read_pickle_object(static_files_path + 'PorterStemmer.pkl')
    # Remove any character that is not an alphabetic character
    text = re.sub("[^a-zA-z]", " ", text).lower()
    # Convert sentence to an array of words
    text = text.split()
    # Ignore stopwords and stem the important (effective) words
    text = [ ps.stem(word) for word in text if word not in set(stopwords)]
    # Convert it back to a single string
    text = " ".join(text)
    return text

def encode(text, cv):
    # Function to encode the text using an object of CountVectorizer
    encoded_text = cv.transform(list([text])).toarray()
    return encoded_text


def decode(result, label_encoder):
    # Function to decode the classification result
    decoded_result = label_encoder.inverse_transform(result)[0]
    return decoded_result

def update(user, learning_style):
    # Function to update learning style of a user (works as a counter)
    # retrieve user's row, get the new learning style, add 1 to its value, update time, save it
    user_vak = VAK.objects.get(user=user)
    old_vak_value = getattr(user_vak, learning_style)
    setattr(user_vak, learning_style, old_vak_value + 1)
    user_vak.updated_at = datetime.now()
    user_vak.save()

def classify(post):
    # Read modules
    label_encoder = read_pickle_object(static_files_path + 'label_encoder.pkl')
    vectorizer = read_pickle_object(static_files_path + 'vectorizer.pkl')
    classifier = read_pickle_object(static_files_path + 'classifier.pkl')
    
    # Get post body, clean it, encode it, classify it, decode result, update user's info
    text = post.body
    cleaned_text = clean(text)
    encoded_text = encode(cleaned_text, vectorizer)
    classification_result = classifier.predict(encoded_text)
    decoded_result = decode(classification_result, label_encoder)
    update(post.user, decoded_result.lower())
 

