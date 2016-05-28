import os, boto3
from uuid import uuid4
from flask import Flask, render_template, jsonify, request
app = Flask(__name__)

@app.route("/hello")
def hello():
    return "Hello World!"

@app.route("/")
def index():
  return render_template('upload.html')

@app.route("/upload", methods=['POST'])
def upload():
  files = request.files
  for f in files.getlist('upl'):
    print f
    upload_s3(f)
    filename = f.filename
    updir = '/home/ec2-user/photoAlbumUi/upload'
    f.save(os.path.join(updir, filename))
  return jsonify()

def upload_s3(source_file):
  bucket_name = '160689-michalo'
  destination_filename = "photos/%s/%s" % (uuid4().hex, source_file.filename)
  s3 = boto3.resource('s3')
  bucket = s3.Bucket(bucket_name)
  bucket.put_object(Key=destination_filename, Body=source_file)

if __name__ == "__main__":
    app.run(host='0.0.0.0', debug=True)
