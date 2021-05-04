#include <GL/glut.h>


void DisplayLine() // The point function 
{
	glClearColor(0, 1, 1, 0);//Window color
	glClear(GL_COLOR_BUFFER_BIT); // empty the buffer
	glColor3f(0, 0, 0);//linecolour

	glLineWidth(10);

	glBegin(GL_LINES); //What will be drawn
	
	glVertex2f(50, 50); //firstvertex place on the window
	glVertex2f(70, 50); //secondvertex place on the window
	
	glEnd(); // I finish the code 
	glFlush(); //put the point on the window
}

int main(int argc, char** argv)
{
	glutInit(&argc, argv);// initialize the Glut library 
	glutInitWindowPosition(100, 100);//window position 
	glutInitWindowSize(600, 600);//windowsize
	glutCreateWindow("Draw a Line"); //window name 
	gluOrtho2D(0, 100, 0, 100); // limits of the shape will be drawn 
	gluOrtho2D(0, 100, 0, 100); // limits of the shape will be drawn 
	glutDisplayFunc(DisplayLine);//calling the function in the main 
	glutMainLoop(); //make it stable
}

