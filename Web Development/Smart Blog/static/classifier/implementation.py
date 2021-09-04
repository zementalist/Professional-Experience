import re
import pickle
import pandas as pd
from nltk.corpus import stopwords
from nltk.stem import PorterStemmer
from sklearn.preprocessing import LabelEncoder
from sklearn.linear_model import LogisticRegression
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import CountVectorizer

# Initialize Stemming class to use 'stem' function
ps = PorterStemmer()

# Select the top n words occured in the dataset
n_top_words = 550

# Import english stopwords
stopwords.words("english")

#nltk.download('stopwords') # Run this if 'english stopwords not found'

# Read dataset
dataset = pd.read_csv("data1.csv")


def clean(text):
    # Function to preprocess text
    # Remove any character that is not an alphabetic character
    text = re.sub("[^a-zA-z]", " ", text).lower()
    # Convert sentence to an array of words
    text = text.split()
    # Ignore stopwords and stem the important (effective) words
    text = [ ps.stem(word) for word in text if word not in set(stopwords.words("english"))]
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

# Clean sentences
sentences = dataset["Sentence"].apply(clean)

# Initialize CountVectorizer so it uses a specific number for top occuring words
count_vector = CountVectorizer(max_features = n_top_words)

# Transform all the sentences to a rows and vector form
X = count_vector.fit_transform(sentences).toarray()

# Set y (the output) to the second column of the dataset
y = dataset.iloc[:, 1]

# Initialize label encoder and encode the learning style labels
label_enc = LabelEncoder()
y = label_enc.fit_transform(y)

# Split the dataset into training set (80% of the samples) and testing set (20%)
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Bulding the model and applying it to the encoded data
classifier = LogisticRegression()
classifier.fit(X_train, y_train)

# Evaluating the model accuracy
score = classifier.score(X_test, y_test) * 100

print("Model score = " + str(score))

# Testing the model

# Get data
sentence1 = "I like to try out things to understand how it works, Experiencing is my power to learn"
sentence2 = "All what we do is to visualize how things work and imagine new possibilities"
sentence3 = "I hear the wind call my name, the sound that leads me home again"

# Preprocess & Encode data
sample1 = encode(clean(sentence1), count_vector)
sample2 = encode(clean(sentence2), count_vector)
sample3 = encode(clean(sentence3), count_vector)

# Classify & Decode results
print( decode(classifier.predict(sample1), label_enc) ) # Kinesthetic
print( decode(classifier.predict(sample2), label_enc) ) # Visual
print( decode(classifier.predict(sample3), label_enc) ) # Auditory


#joblib.dump(label_enc, 'label_encoder.joblib')
#joblib.dump(count_vector, 'vectorizer.joblib')
#joblib.dump(classifier, 'classifier.joblib')
#joblib.dump(stopwords.words("english"), 'stopwords.joblib')
#joblib.dump(ps, 'PorterStemmer.joblib')

pkl_file_names = ['label_encoder.pkl', 'vectorizer.pkl', 'classifier.pkl',
                  'stopwords.pkl', 'PorterStemmer.pkl'
                  ]
objects_to_save = [label_enc, count_vector, classifier, 
                   stopwords.words('english'), ps
                   ]

for i in range(len(pkl_file_names)):
    with open(pkl_file_names[i], 'wb') as file:
        pickle.dump(objects_to_save[i], file)

