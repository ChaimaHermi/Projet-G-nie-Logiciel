/***********************************************************************
 * Module:  Assessment_work_eval.java
 * Author:  ayeta
 * Purpose: Defines the Class Assessment_work_eval
 ***********************************************************************/

import java.util.*;

/** @pdOid e41e254b-a04e-4ed1-896a-4f2a336df8c6 */
public class Assessment_work_eval {
   /** @pdOid 2b46085c-0a17-4399-a8e3-6cdb3b45a0bb */
   private int value;
   /** @pdOid d8bd3ac4-fcc1-403e-9347-8f060bca9bc7 */
   private String notes;
   /** @pdOid 933f7eb5-4b7b-4d75-ada2-63d8a4fa123f */
   private String pictures;
   
   /** @pdRoleInfo migr=no name=Assessment_item assc=Association_16 coll=java.util.Collection impl=java.util.HashSet mult=1..* type=Composition */
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