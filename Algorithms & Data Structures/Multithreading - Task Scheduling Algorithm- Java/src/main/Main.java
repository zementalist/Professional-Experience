/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package main;

import java.lang.Thread;
import java.util.Vector;
//import java.util.List;






class Main {
  public static void main(String[] args) {
    // Initialize data (processes)
    int numberOfProcesses = 4;
    int quantum = 4;
    Vector titles = new Vector();
    titles.add("p1");
    titles.add("p2");
    titles.add("p3");
    titles.add("p4");
    Vector burstTimes = new Vector();
    burstTimes.add(12);
    burstTimes.add(6);
    burstTimes.add(3);
    burstTimes.add(8);
    Vector arrivalTimes = new Vector();
    arrivalTimes.add(0);
    arrivalTimes.add(5);
    arrivalTimes.add(0);
    arrivalTimes.add(10);

    // collect processes into Data object
    Data singleProcessorData = new Data(numberOfProcesses, titles, burstTimes, arrivalTimes);
    
    // initialize a single processor with data, set its name
    Processor singlePr = new Processor(singleProcessorData, quantum);
    singlePr.setName("Processor-0");

    System.out.println("Before Multiprocessing\n");
    System.out.println("Processor\t\tProcess\t\tStart\t\tFinish\n");
    // start single processing and wait until finish (synchronized)
    singlePr.start();
    try{
        singlePr.join();
        System.out.println("\nAfter Multiprocessing\n");

    }
    catch(InterruptedException e) {}

    // Distribute Data(processes)
    Data processor1Data = new Data(2, titles.subList(0, 2), burstTimes.subList(0, 2), arrivalTimes.subList(0, 2));
    Data processor2Data = new Data(2, titles.subList(2, 4), burstTimes.subList(2, 4), arrivalTimes.subList(2, 4));

    // Initialize 2 Multiprocessors with    Data
    Processor pr1 = new Processor(processor1Data, quantum);
    Processor pr2 = new Processor(processor2Data, quantum);
    pr1.setName("Processor-1");
    pr2.setName("Processor-2");
    
    //start parallel processing
    pr1.start();
    pr2.start();
    // wait until finish
    try{
      pr1.join();
      pr2.join();
    }
    catch(InterruptedException e) {}
    // Analyze data
    // rpt = requiredProcessingTime, calculate enhancement factor
    int single_pr_rpt = singlePr.requiredProcessingTime;
    int multi_pr1_rpt = pr1.requiredProcessingTime;
    int multi_pr2_rpt = pr2.requiredProcessingTime;
    // One thread may finish before the other, we conside the last thread (longest time)
    int multi_processing_total_rpt = (multi_pr1_rpt > multi_pr2_rpt ? multi_pr1_rpt : multi_pr2_rpt);
    // enhancement = (difference / total) * 100
    float enhancement = ((float)single_pr_rpt - multi_processing_total_rpt) / single_pr_rpt * 100;
    // print results
    System.out.println("\nSingle processor finished in " + single_pr_rpt + " unit of time\nMultiprocessors finished in " + multi_processing_total_rpt + " unit of time\n" + "Enhancement Factor = " + (enhancement)+"%");

    
  }

  static class Processor extends Thread {
    public Data data;
    public int quantum;
    public int requiredProcessingTime;
    Processor(Data data, int quantum) {
      this.data = data;
      this.quantum = quantum;
    }
    @Override
    public void run() {

        this.requiredProcessingTime = Algorithms.roundRobin(this.data, this.quantum);

    }
  }

}