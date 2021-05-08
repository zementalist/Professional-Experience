// OSProject.cpp : This file contains the 'main' function. Program execution begins and ends there.
//

#include "pch.h"
#include <iostream>
#include <vector>
#include <fstream>
#include <fstream>
#include <string>
#include <string>
#include <cstdlib>
#include <ctime>
#include <Windows.h>
using namespace std;

class RR {
public:
	int Q;
	unsigned int arr[10];
	int TurnAround[10];
	int Number;
	int Timer[10];
	int Averngers[10];
	void GetInfo();
	int ArriveTime[10];
	//void AlogrsimFromFile();
	void AlogrisimRR();
	void AlogrisimRRWithArrive();
	void turn_around();
	void waitingTime();
	void decide();
	//void GettingInfoFromFile();

};
using namespace std;

void RR::AlogrisimRRWithArrive() {
	int i, time = 0, R, temps = 0, Q2;

	int Waiting = 0, TotalTime = 0;

	cout << "Number of BuresTime" << endl;
	cin >> Number;

	R = Number;
	vector<int>BusrtTime(Number);
	vector<int>Copy(Number);

	int count = 0;
	cout << "Enter the Arrival time" << endl;
	for (i = 0;i < Number;i++)
	{
		cout <<  "Arrive"<<i<<" ";
		cin >> ArriveTime[i];
		if (ArriveTime[i] == 0) {
			count++;
		}
	}
	if (count == 4) {//Turn to  Anther Alogrsim
		cout << "You Are tunred to Alogrsim RR without ArriveTime" << endl;
		AlogrisimRR();
	}
	cout << "You Are in  Alogrsim  with ArriveTime" << endl;
	cout << "Process" << " " << "BusrtTime" << endl;
	for (int i = 0;i < Number;i++) {
		cout << "P" << i + 1 << " ";
		cin >> BusrtTime[i];//
		Copy[i] = BusrtTime[i];
		cout << endl;
	}
	int TimeManger[100];
	cout << "Enter the Quantum Value" << endl;
	cin >> Q2;
	cout << time;
	for (time = 0, i = 0;R != 0;)
	{

		if (Copy[i] <= Q2 && Copy[i] > 0)
		{
			cout << "|P" << "" << "| ";
			cout << "";

			time += Copy[i];
			Copy[i] = 0;
			temps = 1;
			cout << time;

		}
		else if (Copy[i] > 0)
		{
			cout << "|P" << "" << "| ";
			cout << "";

			Copy[i] -= Q2;
			time += Q2;
			cout << time;
		}

		if (Copy[i] == 0 && temps == 1)
		{
			R--;
			TimeManger[i] = time;
			Waiting += time - ArriveTime[i] - BusrtTime[i];
			TotalTime += time - ArriveTime[i];
			temps = 0;
		}

		if (i == Number - 1)
			i = 0;
		else if (ArriveTime[i + 1] <= time)
			i++;
		else
			i = 0;
	}
	cout << endl;
	cout << "------------------------------------------------------" << endl;

	cout << "\n\nProcess\t:      Turnaround Time:       Waiting Time\n\n";
	for (int i = 0;i < Number;i++) {
		cout << endl;
		printf("Process{%d}\t:\t%d\t:\t%d\n", i + 1, TimeManger[i] - ArriveTime[i], TimeManger[i] - ArriveTime[i] - BusrtTime[i]);
	}
	cout << "------------------------------------------------------" << endl;
	cout << "Average Turnaround Time is " << TotalTime * 1.0 / Number << endl;
	cout << "------------------------------------------------------" << endl;
	cout << "Averag WaitingTime is " << Waiting * 1.0 / Number << endl;
	cout << "------------------------------------------------------" << endl;
}
void RR::GetInfo() {
	cout << "Enter the Quantum Value" << endl;
	cin >> Q;

	cout << "Process" << " " << "BusrtTime" << endl;
	for (int m = 0;m < Number;m++) {
		cout << "P" << m + 1 << " ";
		cin >> arr[m];
		cout << endl;
	}
}

void RR::turn_around() {
	cout << endl;
	int sum = 0;
	double avg;
	for (int i = 0;i < Number;i++) {
		cout <<"P"<<i+1<< " Turning Time " << Timer[i] - ArriveTime[i] << endl;
		Averngers[i] = Timer[i] - ArriveTime[i];

		sum += Averngers[i];
	}
	avg = sum / Number;
	cout << "TurningTime is " << " " << avg << "ms";
}
void RR::waitingTime() {
	cout << endl;
	int sum = 0;
	double avg;
	for (int i = 0;i < Number;i++) {
		cout << "P" << i + 1 << " Waiting Time " << Timer[i] - arr[i] << endl;
		Averngers[i] = Timer[i] - arr[i];

		sum += Averngers[i];
	}
	avg = sum / Number;
	cout << "WaitingTime is " << " " << avg << "ms";
}

void RR::AlogrisimRR() {
	RR::GetInfo();
	int time = 0;
	int arrs[10] = { 0 };
	for (int j = 0;j < Number;j++) {
		arrs[j] = arr[j];
	}
	cout << time;
	int i = 0;
	int Count = Number;
	while (Count != 0) {
		if (arrs[i] > Q) {
			arrs[i] = arrs[i] - Q;//8  4
			cout << "-P" << i + 1 << "-";
			time += Q;//10
			cout << time;

		}
		else if (arrs[i] <= Q && arrs[i] > 0) {
			time += arrs[i];
			arrs[i] = 0;//
			cout << "-P" << i + 1 << "-";
			Count--;
			cout << time;
			Timer[i] = time;
		}
		i++;
		if (i == Number) {
			i = 0;
		}
	}
	cout << endl;
	cout << "----------------------" << endl;
	cout << endl;
	RR::turn_around();
	cout << endl;

	cout << "----------------------" << endl;
	cout << endl;
	RR::waitingTime();
	cout << endl;

	cout << "----------------------" << endl;

	exit(0);
}
int main()
{
	RR r;
	r.AlogrisimRRWithArrive();
}

