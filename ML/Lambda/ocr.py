import json
import boto3
import re

def lambda_handler(event, context):
    #filePath = "Uber, Orange County, 1-1595272179953.jpg"
    #filePath = "Uber, Los Angeles, 1-1595268818951.jpg"
    #filePath = "Lyft, Purcellville, 2-1595289095379.jpg"
    #filePath = "Lyft, Purcellville, 3-1595290142999.jpg"
    #filePath = "Postmates, Lake Stevens, 1-1595367046490.jpeg"
    #filePath = "DoorDash, Lake Stevens, 1-1595371148919.jpeg"
    #filePath = "Grubhub, Ellicott City, 1-1595375134028.png"
    #filePath = "Grubhub, Costa Mesa, 1-1595375144401.jpg"
    #filePath = event["Records"][0]["s3"]["object"]["key"].replace("+", " ").replace("%2C", ",")
    filePath = event["file"]
    print("File Path:")
    print(filePath)
    bad_chars = ["$"]
    
    s3BucketName = "mogle-screenshots-before"
    documentName = filePath
    textract = boto3.client("textract")
    
    # Call Amazon Textract
    response = textract.detect_document_text(
        Document = {
            'S3Object': {
                'Bucket': s3BucketName,
                'Name': documentName
            }
        }
    )
        
    result = []
    processedResult = ""
    for item in response["Blocks"]:
        if item["BlockType"] == "WORD":
            result.append(item["Text"])
            element = item["Text"] + " "
            processedResult += element
    print (processedResult)
    
    platform = None
    date = None
    result = []
    
    # Formate date
    def formatDate(date):
        dateArray = date.split(" ")
        month = dateArray[0].upper()
        months = {"JAN": 1, "FEB": 2, "MAR": 3, "APR": 4, "MAY": 5, "JUN": 6, "JUL": 7, "AUG": 8, "SEP": 9, "OCT": 10, "NOV": 11, "DEC": 12}
        month = str(months[month])
        day = dateArray[1]
        date = "2020-" + month + "-" + day
        return date
        
    # Process Uber
    def processUber():
        date = re.search(r"\b[A-Z][a-z][a-z]\.\s*[A-Z][A-Za-z][A-Za-z]\s*\d{1,2}\b", processedResult)[0]
        if date != None:
            date = formatDate(re.search("[A-Z][A-Za-z][A-Za-z]\s*\d{1,2}", date)[0])
        data = re.findall(r"\b\d{1,2}\:\d{2}\s*[A|P][M]\s*0?\s*\$\d{1,3}\.\d{2}\b", processedResult)
        if data != None:
            for datum in data:
                time = re.search("\d{1,2}\:\d{2}", datum)[0]
                AMPM = re.search("[A|P][M]", datum)[0]
                if AMPM == "PM":
                    timeArray = time.split(":")
                    hour = str(int(timeArray[0]) + 12)
                    minute = timeArray[1]
                    time = hour + ":" + minute
                earnings = re.search("\$\d{1,3}\.\d{2}", datum)[0]
                for i in bad_chars:
                    time = time.replace(i, "")
                    earnings = earnings.replace(i, "")
                datetime = date + "T" + time + "Z"
                datum = (platform, datetime, earnings)
                result.append(datum)
        
    # Process Lyft
    def processLyft():
        date = re.search(r"\b(Today|[A-Z][a-z][a-z])\s*[A-Z][a-z][a-z]\s*\d{1,2}\b", processedResult)[0]
        if date != None:
            date = formatDate(re.search("[A-Z][a-z][a-z]\s*\d{1,2}", date)[0])
        data = re.findall(r"\bLyft\s*\d{1,2}\:\d{2}\s*\$\d{1,3}\.\d{2}\b", processedResult)
        if data != None:
            for datum in data:
                time = re.search("\d{1,2}\:\d{2}", datum)[0]
                earnings = re.search("\$\d{1,3}\.\d{2}", datum)[0]
                for i in bad_chars:
                    time = time.replace(i, "")
                    earnings = earnings.replace(i, "")
                datetime = date + "T" + time + "Z"
                datum = (platform, datetime, earnings)
                result.append(datum)
                
    # Process Postmates
    def processPostmates():
        data = re.findall(r"\bDelivery\s*\d{2}\/\d{2}\/\d{4}\,\s*\d{1,2}\:\d{2}\s*[A|P][M]\s*\$\d{1,3}\.\d{2}\b", processedResult)
        if data != None:
            for datum in data:
                date = re.search("\d{2}\/\d{2}\/\d{4}", datum)[0]
                dateArray = date.split("/")
                month = dateArray[0]
                day = dateArray[1]
                year = dateArray[2]
                date = year + "-" + month + "-" + day
                time = re.search("\d{1,2}\:\d{2}", datum)[0]
                earnings = re.search("\$\d{1,3}\.\d{2}", datum)[0]
                for i in bad_chars:
                    date = date.replace(i, "")
                    time = time.replace(i, "")
                    earnings = earnings.replace(i, "")
                datetime = date + "T" + time + "Z"
                datum = (platform, datetime, earnings)
                result.append(datum)
                
    # Process DoorDash
    def processDoorDash():
        print("DoorDash")
        date = re.search(r"\b[A-Z][a-z][a-z]\s*\d{1,2}\b", processedResult)[0]
        if date != None:
            date = formatDate(re.search("[A-Z][a-z][a-z]\s*\d{1,2}", date)[0])
        time = re.search(r"\b\d{1,2}\:\d{2}[a|p][m]\s*\-\s*\d{1,2}\:\d{2}[a|p][m]\b", processedResult)[0]
        if time != None:
            timeArray = time.split("-")
            start = timeArray[0].strip()
            end = timeArray[1].strip()
            print(start)
            print(end)
        data = re.findall("\$\d{1,3}\.\d{2}", processedResult)
        if data != None:
            for datum in data:
                earnings = re.search("\$\d{1,3}\.\d{2}", datum)[0]
                for i in bad_chars:
                    time = time.replace(i, "")
                    earnings = earnings.replace(i, "")
                datetime = date + "T" + time + "Z"
                datum = (platform, datetime, earnings)
                result.append(datum)
                
    # Process Grubhub
    def processGrubhub():
        print("Grubhub")
        date = re.search(r"\bToday\,\s*[A-Z][a-z][a-z]\s*\d{1,2}\,\s*\d{4}\b", processedResult)[0]
        if date != None:
            date = formatDate(re.search("[A-Z][a-z][a-z]\s*\d{1,2}", date)[0])
        
        
        
#        else:
#            month = re.findall(r"\bJan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec\b", processedResult)[-1]
#            day = re.findall("\s\d{2}\s", processedResult)[-1]
#            date = month + day
#            if date != None:
#                date = formatDate(date)
#            data = re.findall(r"\bLyft\s*\d{1,2}\:\d{2}\s*\$\d{1,3}\.\d{2}\b", processedResult)
#            if data != None:
#                for datum in data:
#                    time = re.search("\d{1,2}\:\d{2}", datum)[0]
#                    earnings = re.search("\$\d{1,3}\.\d{2}", datum)[0]
#                    for i in bad_chars:
#                        time = time.replace(i, "")
#                        earnings = earnings.replace(i, "")
#                    datetime = date + "T" + time + "Z"
#                    datum = (platform, datetime, earnings)
#                    result.append(datum)
    
    # Platform
    Uber = re.search("uber", processedResult)
    Lyft = re.search(r"\bLyft\b", processedResult)
    Uber_Eats = re.search(r"\bUBEREATS\b", processedResult)
    Postmates = re.search(r"\bCURRENT\s*BALANCE\b", processedResult)
    DoorDash = re.search(r"\bDash\b", processedResult)
    Caviar = re.search(r"\bCAVIAR\b", processedResult)
    Grubhub = re.search(r"\bEarnings\s*Activity\b", processedResult)
    if Uber != None:
        platform = "Uber"
        processUber()
    elif Lyft != None:
        platform = "Lyft"
        processLyft()
    elif Uber_Eats != None:
        platform = "Uber Eats"
        processUberEats()
    elif Postmates != None:
        platform = "Postmates"
        processPostmates()
    elif DoorDash != None:
        platform = "DoorDash"
        processDoorDash()
    elif Caviar != None:
        platform = "Caviar"
        processCaviar()
    elif Grubhub != None:
        platform = "Grubhub"
        processGrubhub()
    print(result)
    
    return {
        "statusCode": 200,
        "body": result
    }