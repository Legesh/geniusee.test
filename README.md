# geniusee.test

Step functions config:

{
  "Comment": "Search dog inside image from s3",
  "StartAt": "Search dog",
  "States": {
    "Search dog": {
      "Type": "Task",
      "Resource": "arn:aws:lambda:us-east-1:293166823260:function:search-dog-inside-image-dev-searchDog",
      "Next": "Is dog found"
    },
    "Is dog found" : {
      "Type": "Choice",
      "Choices": [ 
          {
            "Variable": "$.status",
            "NumericEquals": 200,
            "Next": "Dog found"
          },
          {
            "Variable": "$.status",
            "NumericEquals": 404,
            "Next": "Dog not found"
          }
      ]
    },
    "Dog found": {
      "Resource": "arn:aws:lambda:us-east-1:293166823260:function:search-dog-inside-image-dev-saveToDB",
      "Type": "Task",
      "End": true
    },
    "Dog not found": {
      "Type": "Task",
      "Resource": "arn:aws:lambda:us-east-1:293166823260:function:search-dog-inside-image-dev-sendEmail",
      "End": true
    }
  }
}
