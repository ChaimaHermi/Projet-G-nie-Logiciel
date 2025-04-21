/***********************************************************************
 * Module:  Kpi.java
 * Author:  ayeta
 * Purpose: Defines the Class Kpi
 ***********************************************************************/

import java.util.*;

/** @pdOid 770d3dbd-37e7-4e4f-b151-949b96aa9af9 */
public class Kpi {
   /** @pdOid 71d83fb7-bb65-4c6c-a3d2-1e636cc7b127 */
   private int value;
   /** @pdOid 84abc995-713c-47ae-97ca-f21a0b1b9a54 */
   private String label;
   /** @pdOid 721790f4-24d6-4923-ae92-4ff052370b70 */
   private String status;
   
   /** @pdRoleInfo migr=no name=Assessment_item assc=Association_10 coll=java.util.Collection impl=java.util.HashSet mult=0..* */
   public java.util.Collection<Assessment_item> assessment_item;
   
   
   /** @pdGenerated default getter */
   public java.util.Collection<Assessment_item> getAssessment_item() {
      if (assessment_item == null)
         assessment_item = new java.util.HashSet<Assessment_item>();
      return assessment_item;
   }
   
   /** @pdGenerated default iterator getter */
   public java.util.Iterator getIteratorAssessment_item() {
      if (assessment_item == null)
         assessment_item = new java.util.HashSet<Assessment_item>();
      return assessment_item.iterator();
   }
   
   /** @pdGenerated default setter
     * @param newAssessment_item */
   public void setAssessment_item(java.util.Collection<Assessment_item> newAssessment_item) {
      removeAllAssessment_item();
      for (java.util.Iterator iter = newAssessment_item.iterator(); iter.hasNext();)
         addAssessment_item((Assessment_item)iter.next());
   }
   
   /** @pdGenerated default add
     * @param newAssessment_item */
   public void addAssessment_item(Assessment_item newAssessment_item) {
      if (newAssessment_item == null)
         return;
      if (this.assessment_item == null)
         this.assessment_item = new java.util.HashSet<Assessment_item>();
      if (!this.assessment_item.contains(newAssessment_item))
         this.assessment_item.add(newAssessment_item);
   }
   
   /** @pdGenerated default remove
     * @param oldAssessment_item */
   public void removeAssessment_item(Assessment_item oldAssessment_item) {
      if (oldAssessment_item == null)
         return;
      if (this.assessment_item != null)
         if (this.assessment_item.contains(oldAssessment_item))
            this.assessment_item.remove(oldAssessment_item);
   }
   
   /** @pdGenerated default removeAll */
   public void removeAllAssessment_item() {
      if (assessment_item != null)
         assessment_item.clear();
   }

}