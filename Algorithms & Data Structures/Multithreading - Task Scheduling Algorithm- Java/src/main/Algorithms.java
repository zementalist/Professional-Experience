/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package main;

import java.util.Vector;

/**
 *
 * @author Zeyad-Pc
 */
class Algorithms {
    // Round-Robin algorithm
    public static int roundRobin(Data data, int quantum) {
      // Convert data to processes, each process has its own properties
      Vector<Process> processes = extractProcesses(data);
      int currentTime = 0;
      Vector<String> finishedProcess = new Vector();
      int iterator = 0; // track which process is processing
      boolean finished = false;
      // use try & catch to use Thread.sleep()
      try{
          // loop over and over again on processes vector
      while(!finished) {
        int currentIndex = iterator % data.numberOfProcesses;
        Process currentProcess = processes.get(currentIndex);
        boolean prcArrived = currentProcess.arrival <= currentTime;
        // if process is arrived
        if(prcArrived) {
          boolean needToProcess = currentProcess.burst > 0;
          // if the process isn't finished yet & needs to process
          if(needToProcess) {
            int timeToWork = (currentProcess.burst > quantum ? quantum : currentProcess.burst);
            int now = currentTime; // get a copy of currentTime value before change
            Thread.sleep(timeToWork*1000);
            System.out.println(Thread.currentThread().getName() + "\t\t  "  +currentProcess.title+ "\t\t  " + now + "\t\t  " + (timeToWork+now));
            currentProcess.burst -= timeToWork;
            currentTime += timeToWork;
            // check if process is finished
            boolean prcFinished = currentProcess.burst == 0;
            // if process has finished, add it to finished-processes vector
            if(prcFinished) {
              // turnaround = finishTime - arrival
              currentProcess.turnaround = currentTime - currentProcess.arrival;
              // waitingTime = turnaround - burst
              currentProcess.waiting = currentProcess.turnaround - currentProcess.burstAsConst;
              finishedProcess.add(currentProcess.title);
              finished = finishedProcess.size() == data.numberOfProcesses;
            }
          }
        }
        // if process doesn't arrive yet, see what's next
        else {
          Thread.sleep(1000);
          currentTime++;
        }
        iterator++;
      }
      }
      catch(InterruptedException e) {}
      // return time needed to finish all processes
      return currentTime;
    }
  public static Vector extractProcesses(Data data) {
    Vector<Process> processes = new Vector();
    for(int d = 0; d < data.numberOfProcesses; d++) {
      String processTitle = data.titles.get(d);
      int processBurst = data.burstTimes.get(d);
      int processArrival = data.arrivalTimes.get(d);
      Process pr = new Process(processTitle, processBurst, processArrival);
      processes.add(pr);
    }
    return processes;
  }
}
