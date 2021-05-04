#include <GL/glut.h>



void DisplayPoint() // The point function 
{
	glClearColor(1, 1, 1, 0);//Window color
	glClear(GL_COLOR_BUFFER_BIT); // empty the buffer
	glColor3f(1, 0, 0);//pointcolour
	
	//glEnable(GL_POINT_SMOOTH); // make the the point with rounded sides
	//glPointSize(20); //Point Size

	glBegin(GL_POINTS); //What will be drawn
	glVertex2f(100,100); //Point place in the window
	glEnd(); // I finish the code 
	glFlush(); //put the point on the window


}

int main(int argc, char** argv)
{
	glutInit(&argc, argv);// initialize the Glut library 
	glutInitWindowPosition(100, 100);//window position 
	glutInitWindowSize(600,600);//windowsize
	glutCreateWindow("Draw a Point"); //window name 
	gluOrtho2D(0, 200, 0, 200); // limits of the shape will be drawn 
	glutDisplayFunc(DisplayPoint);//calling the function in the main 
	glutMainLoop(); //make it stable
}

