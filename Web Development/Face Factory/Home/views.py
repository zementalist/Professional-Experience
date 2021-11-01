from django.shortcuts import render
# from detector.views import detect

# Create your views here.
def index(request):
    if request.method == 'GET':
        return render(request, './home/main.html')
    else:
    	return None

