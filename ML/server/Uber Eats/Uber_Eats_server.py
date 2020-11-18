# Jupyter Notebook code
import helpers
import pandas as pd
import numpy as np
import datetime as dt
from sklearn import preprocessing
from sklearn.model_selection import cross_val_score

SECONDS_IN_YEAR = (dt.datetime(2021, 1, 1) - dt.datetime(2020, 1, 1)).total_seconds()

def get_population_density(location):
#    if location == "Columbia;MD":
#        return 1
    return 1

def get_SINE(date):
    seconds = (date - dt.datetime(2020, 1, 1, 0)).total_seconds()
    return np.sin(2 * np.pi * seconds / SECONDS_IN_YEAR)

def get_COSINE(date):
    seconds = (date - dt.datetime(2020, 1, 1, 0)).total_seconds()
    return np.cos(2 * np.pi * seconds / SECONDS_IN_YEAR)

def get_hour_difference(start_datetime, end_datetime):
    return (end_datetime - start_datetime).total_seconds() / 3600

# Uber Eats
# Import file
import_file_Uber_Eats = "Uber_Eats_Columbia_MD_V2.csv"
columns = ["Location", "Datetime", "NPEPH"]
df_Uber_Eats = pd.read_csv(import_file_Uber_Eats, names=columns)

# Change to numerical data
df_Uber_Eats["Location"] = df_Uber_Eats["Location"].map(get_population_density)
df_Uber_Eats["Datetime"] = pd.to_datetime(df_Uber_Eats["Datetime"], format="%Y-%m-%d", errors="coerce")
df_Uber_Eats["DayOfWeek"] = df_Uber_Eats["Datetime"].dt.dayofweek
df_Uber_Eats["Datetime"] = (df_Uber_Eats["Datetime"] - dt.datetime(2020, 1, 1)).dt.total_seconds()
df_Uber_Eats["Datetime_SINE"] = np.sin(2 * np.pi * df_Uber_Eats["Datetime"] / SECONDS_IN_YEAR)
df_Uber_Eats["Datetime_COSINE"] = np.cos(2 * np.pi * df_Uber_Eats["Datetime"] / SECONDS_IN_YEAR)
df_Uber_Eats = df_Uber_Eats[["Location", "Datetime_SINE", "Datetime_COSINE", "DayOfWeek", "NPEPH"]]

# Separate features and classes
feature_names_Uber_Eats = ["Location", "Datetime_SINE", "Datetime_COSINE", "DayOfWeek"]
all_features_Uber_Eats = df_Uber_Eats[feature_names_Uber_Eats].values
all_classes_NPEPH_Uber_Eats = df_Uber_Eats["NPEPH"].values

# Normalize data
scaler = preprocessing.StandardScaler()
all_features_scaled_Uber_Eats = scaler.fit_transform(all_features_Uber_Eats)

# Stats
# Uber Eats
NPEPH_mean_Uber_Eats = df_Uber_Eats["NPEPH"].mean()
NPEPH_std_Uber_Eats = df_Uber_Eats["NPEPH"].std()
NPEPH_variance_Uber_Eats = NPEPH_std_Uber_Eats * NPEPH_std_Uber_Eats

# RBF SVM
from sklearn import svm

# Hyperparameters
C = 1.0

svr = svm.SVR(kernel="rbf", C=C)

# Return RBF SVM estimates and k-fold cross-validation scores for Uber Eats
def get_RBF_SVM_Uber_Eats(location, datetime_SINE, datetime_COSINE, dayOfWeek):
    test_input = [[location, datetime_SINE, datetime_COSINE, dayOfWeek]]
    # NPEPH
    cv_scores = cross_val_score(svr, all_features_scaled_Uber_Eats, all_classes_NPEPH_Uber_Eats, cv=10)
    NPEPH_k = cv_scores.mean()
    svr.fit(all_features_scaled_Uber_Eats, all_classes_NPEPH_Uber_Eats)
    NPEPH = svr.predict(test_input)[0]
    NPEPH_array = [NPEPH, NPEPH_k, "NPEPH"]
    return [NPEPH_array]

# Stats
from scipy.stats import norm
import math

# Server
from flask import Flask, jsonify, request
from flask_cors import CORS, cross_origin

app = Flask(__name__)
cors = CORS(app)
app.config['CORS_HEADERS'] = 'Content-Type'

@app.route("/get_estimate", methods=["POST"])
@cross_origin()
def get_estimate():
    body = request.get_json()
    loc = body["location"]
    print(loc)
    platform = body["platform"]
    start_date = body["start_date"]
    start_date_array1 = start_date.split("T")
    start_date_array2 = start_date_array1[0].split("-")
    start_date_year = int(start_date_array2[0])
    start_date_month = int(start_date_array2[1])
    start_date_day = int(start_date_array2[2])
    start_date_array3 = start_date_array1[1].split(":")
    start_date_hour = int(start_date_array3[0])
    end_date = body["end_date"]
    end_date_array1 = end_date.split("T")
    end_date_array2 = end_date_array1[0].split("-")
    end_date_year = int(end_date_array2[0])
    end_date_month = int(end_date_array2[1])
    end_date_day = int(end_date_array2[2])
    end_date_array3 = end_date_array1[1].split(":")
    end_date_hour = int(end_date_array3[0])
    if platform == "Uber_Eats":
        location = get_population_density(loc)
        datetime = dt.datetime(start_date_year, start_date_month, start_date_day, start_date_hour, 0)
        datetime_SINE = get_SINE(datetime)
        datetime_COSINE = get_COSINE(datetime)
        dayOfWeek = datetime.weekday()
        data = get_RBF_SVM_Uber_Eats(location, datetime_SINE, datetime_COSINE, dayOfWeek)
        estimate = round(data[0][0], 2)
        test_variance = NPEPH_variance_Uber_Eats
        return jsonify({ "estimate": estimate, "test_variance": test_variance })

@app.route("/get_premium", methods=["POST"])
@cross_origin()
def get_premium():
    body = request.get_json()
    total = float(body["total"])
    variance = float(body["variance"])
    if variance == 0:
        std = 0
    else:
        std = math.sqrt(variance)
    base = norm(loc=total, scale=std)
    premium = round(base.expect(lambda x: abs(x - total), lb=0, ub=total), 2)
    return jsonify({ "premium": premium })

if __name__ == "__main__":
    app.run(debug=True)