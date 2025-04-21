/***********************************************************************
 * Module:  Assessment_work.java
 * Author:  ayeta
 * Purpose: Defines the Class Assessment_work
 ***********************************************************************/

import java.util.*;

/** @pdOid 55c25a7b-1bf4-4f28-9103-16aa8a62034a */
public class Assessment_work {
   /** @pdOid 8f09d389-5df3-4247-be95-a482976046dc */
   private String status;
   /** @pdOid 28eec9cc-3165-48e0-b736-d2efce3b99fe */
   private String report;
   
   /** @pdRoleInfo migr=no name=Office assc=Association_6 coll=java.util.Collection impl=java.util.HashSet mult=1..1 */
   public Office office;
   /** @pdRoleInfo migr=no name=Project assc=Association_7 coll=java.util.Collection impl=java.util.HashSet mult=0..1 */
   public Project project;
   /** @pdRoleInfo migr=no name=Assessment_work_eval assc=Association_15 coll=java.util.Collection impl=java.util.HashSet mult=1..1 type=Composition */
   public Assessment_work_eval assessment_work_eval;

}