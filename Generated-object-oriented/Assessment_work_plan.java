/***********************************************************************
 * Module:  Assessment_work_plan.java
 * Author:  ayeta
 * Purpose: Defines the Class Assessment_work_plan
 ***********************************************************************/

import java.util.*;

/** @pdOid 7e2cf794-48eb-481c-a1d4-44ddd5f77110 */
public class Assessment_work_plan {
   /** @pdOid 31735b34-ebea-4c3d-947f-7e60975c3390 */
   private String reference;
   /** @pdOid 01e4dd28-035d-4500-8889-fc3fac71fb51 */
   private String status;
   /** @pdOid 4ad7c580-bbd9-4269-b193-a747bc835997 */
   private String offices;
   /** @pdOid 87d8498c-ea76-454c-b25a-3e0fe96d12a7 */
   private String type;
   /** @pdOid 3b128cbe-51f4-448c-9145-4d615deffa00 */
   private String notes;
   /** @pdOid 27844eb6-e15d-4b12-9360-60bcf24fffc0 */
   private java.util.Date date;
   
   /** @pdRoleInfo migr=no name=Assessment_type assc=Association_4 coll=java.util.Collection impl=java.util.HashSet mult=1..1 */
   public Assessment_type assessment_type;
   /** @pdRoleInfo migr=no name=Assessment_work assc=Association_5 coll=java.util.Collection impl=java.util.HashSet mult=1..* */
   public java.util.Collection<Assessment_work> assessment_work;
   
   
   /** @pdGenerated default getter */
   public java.util.Collection<Assessment_work> getAssessment_work() {
      if (assessment_work == null)
         assessment_work = new java.util.HashSet<Assessment_work>();
      return assessment_work;
   }
   
   /** @pdGenerated default iterator getter */
   public java.util.Iterator getIteratorAssessment_work() {
      if (assessment_work == null)
         assessment_work = new java.util.HashSet<Assessment_work>();
      return assessment_work.iterator();
   }
   
   /** @pdGenerated default setter
     * @param newAssessment_work */
   public void setAssessment_work(java.util.Collection<Assessment_work> newAssessment_work) {
      removeAllAssessment_work();
      for (java.util.Iterator iter = newAssessment_work.iterator(); iter.hasNext();)
         addAssessment_work((Assessment_work)iter.next());
   }
   
   /** @pdGenerated default add
     * @param newAssessment_work */
   public void addAssessment_work(Assessment_work newAssessment_work) {
      if (newAssessment_work == null)
         return;
      if (this.assessment_work == null)
         this.assessment_work = new java.util.HashSet<Assessment_work>();
      if (!this.assessment_work.contains(newAssessment_work))
         this.assessment_work.add(newAssessment_work);
   }
   
   /** @pdGenerated default remove
     * @param oldAssessment_work */
   public void removeAssessment_work(Assessment_work oldAssessment_work) {
      if (oldAssessment_work == null)
         return;
      if (this.assessment_work != null)
         if (this.assessment_work.contains(oldAssessment_work))
            this.assessment_work.remove(oldAssessment_work);
   }
   
   /** @pdGenerated default removeAll */
   public void removeAllAssessment_work() {
      if (assessment_work != null)
         assessment_work.clear();
   }

}